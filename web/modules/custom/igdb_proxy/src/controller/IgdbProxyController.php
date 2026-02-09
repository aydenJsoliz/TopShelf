<?php

namespace Drupal\igdb_proxy\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\HttpFoundation\RequestStack;

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
    $token = $this->getTwitchToken();
    $request = $this->requestStack->getCurrentRequest();

    $limit = 500; // IGDB max page size.
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
  id,
  name,
  summary,
  first_release_date,
  rating,
  cover.url,
  platforms.name,
  genres.name;
limit {$limit};
offset {$offset};
sort first_release_date desc;
IGDB;

      $response = $this->httpClient->post('https://api.igdb.com/v4/games', [
        'headers' => [
          'Client-ID' => $_ENV['IGDB_CLIENT_ID'],
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

      // Normalize cover URL if present (IGDB often returns protocol-relative URLs).
      foreach ($batch as &$g) {
        if (isset($g['cover']['url']) && is_string($g['cover']['url'])) {
          if (str_starts_with($g['cover']['url'], '//')) {
            $g['cover']['url'] = 'https:' . $g['cover']['url'];
          }
        }
      }
      unset($g);

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
        'client_id' => $_ENV['IGDB_CLIENT_ID'],
        'client_secret' => $_ENV['IGDB_CLIENT_SECRET'],
        'grant_type' => 'client_credentials',
      ],
      'timeout' => 15,
    ]);

    $data = json_decode($response->getBody()->getContents(), true);
    $this->state->set('igdb.token', $data['access_token']);

    return $data['access_token'];
  }

}