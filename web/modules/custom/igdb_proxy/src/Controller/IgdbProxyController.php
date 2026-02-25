<?php

namespace Drupal\igdb_proxy\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Site\Settings;

class IgdbProxyController extends ControllerBase {

  protected ClientInterface $httpClient;
  protected StateInterface $state;
  protected RequestStack $requestStack;

  public function __construct(ClientInterface $http_client, StateInterface $state, RequestStack $request_stack) {
    $this->httpClient = $http_client;
    $this->state = $state;
    $this->requestStack = $request_stack;
  }

  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('http_client'),
      $container->get('state'),
      $container->get('request_stack'),
    );
  }

  /**
   * IGDB feed endpoint for Feeds.
   *
   * Supports paging:
   *   /igdb/feed/games?offset=0
   *   /igdb/feed/games?offset=500
   *
   * Also supports bulk mode (NOT recommended for huge datasets):
   *   /igdb/feed/games?all=1
   */
  public function games(): JsonResponse {
    return $this->buildFeedResponse(
      'games',
      <<<FIELDS
  id,
  name,
  summary,
  first_release_date,
  total_rating,
  parent_game,
  screenshots.url,
  cover.url,
  platforms.name,
  genres.name,
  involved_companies.company.name
FIELDS,
      function (array &$game): void {
        // Normalize cover URL if present (IGDB often returns protocol-relative URLs).
        if (isset($game['cover']['url']) && is_string($game['cover']['url'])) {
          if (str_starts_with($game['cover']['url'], '//')) {
            $game['cover']['url'] = 'https:' . $game['cover']['url'];
            $game['cover']['url'] = str_replace('/t_thumb/', '/t_original/', $game['cover']['url']);
          }
        }

        // Flatten involved companies to a comma-separated string for Feeds mapping.
        // $company_names = [];
        // if (!empty($game['involved_companies']) && is_array($game['involved_companies'])) {
        //   foreach ($game['involved_companies'] as $ic) {
        //     if (isset($ic['company']['name']) && is_string($ic['company']['name'])) {
        //       $company_names[] = $ic['company']['name'];
        //     }
        //   }
        // }
        // $game['involved_companies_csv'] = implode(', ', array_values(array_unique($company_names)));
      }
    );
  }

  /**
   * IGDB feed endpoint for Genres.
   *
   * Supports paging:
   *   /igdb/feed/genres?offset=0
   */
  public function genres(): JsonResponse {
    return $this->buildFeedResponse(
      'genres',
      <<<FIELDS
  name
FIELDS
    );
  }

  /**
   * IGDB feed endpoint for Platforms.
   *
   * Supports paging:
   *   /igdb/feed/platforms?offset=0
   */
  public function platforms(): JsonResponse {
    return $this->buildFeedResponse(
      'platforms',
      <<<FIELDS
  name
FIELDS
    );
  }

  /**
   * Get or refresh Twitch OAuth token.
   * NOTE: This simplistic version does not handle expiration; see note below.
   */
  protected function getTwitchToken(): string {
    // If you store expiration too, you can refresh when expired.
    if ($token = $this->state->get('igdb.token')) {
      return $token;
    }

    $response = $this->httpClient->post('https://id.twitch.tv/oauth2/token', [
      'query' => [
        'client_id' => Settings::get('igdb_client_id'),
        'client_secret' => Settings::get('igdb_client_secret'),
        'grant_type' => 'client_credentials',
      ],
      'timeout' => 15,
    ]);

    $data = json_decode($response->getBody()->getContents(), true);
    $this->state->set('igdb.token', $data['access_token']);

    return $data['access_token'];
  }

  /**
   * Shared IGDB feed handler with paging/bulk support.
   */
  protected function buildFeedResponse(string $endpoint, string $fields, ?callable $normalizer = null): JsonResponse {
    $token = $this->getTwitchToken();
    $request = $this->requestStack->getCurrentRequest();

    $limit = 50; // IGDB max page size.
    $offset = max(0, (int) $request->query->get('offset', 0));
    $bulk_all = (bool) $request->query->get('all', false);

    // Safety caps for "all=1" bulk mode to avoid timeouts.
    // Adjust if you control timeouts/memory (CLI/cron is better than HTTP).
    $max_pages = (int) $request->query->get('max_pages', 20); // 20*500 = 10,000 items max per request
    $max_pages = max(1, min($max_pages, 200)); // hard cap at 100k items

    $items = [];
    $page = 0;

    do {
      $query = <<<IGDB
fields
{$fields};
limit {$limit};
offset {$offset};
where total_rating > 40;
sort id desc;
IGDB;

      $response = $this->httpClient->post("https://api.igdb.com/v4/{$endpoint}", [
        'headers' => [
          'Client-ID' => Settings::get('igdb_client_id'),
          'Authorization' => "Bearer {$token}",
          'Accept' => 'application/json',
        ],
        'body' => $query,
        'timeout' => 30,
      ]);

      $batch = json_decode($response->getBody()->getContents(), true);
      if (!is_array($batch)) {
        $batch = [];
      }

      if ($normalizer) {
        foreach ($batch as &$item) {
          $normalizer($item);
        }
        unset($item);
      }

      $items = array_merge($items, $batch);

      // If not bulk mode, we only return a single page for Feeds to iterate.
      if (!$bulk_all) {
        break;
      }

      $offset += $limit;
      $page++;

      // Stop if we got less than a full page.
      $more = count($batch) === $limit;

    } while ($more && $page < $max_pages);

    return new JsonResponse([
      'items' => $items,

      // Helpful metadata for debugging / iterating.
      'meta' => [
        'bulk' => $bulk_all,
        'limit' => $limit,
        'next_offset' => $bulk_all ? $offset : ($offset + $limit),
        'pages_returned' => $bulk_all ? $page : 1,
        'count' => count($items),
        'warning' => $bulk_all && $page >= $max_pages
          ? "Stopped at max_pages={$max_pages} to avoid timeouts. Increase max_pages (carefully) or iterate with offset."
          : null,
      ],
    ]);
  }

}
