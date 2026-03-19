<?php

namespace Drupal\igdb_proxy\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\State\StateInterface;
use Drupal\igdb_proxy\IgdbFields;
use Drupal\igdb_proxy\Service\IgdbClient;
use Drupal\igdb_proxy\Service\IgdbGameNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class IgdbProxyController extends ControllerBase {

  protected IgdbClient $igdbClient;
  protected IgdbGameNormalizer $gameNormalizer;
  protected Connection $database;
  protected StateInterface $state;
  protected RequestStack $requestStack;

  public function __construct(IgdbClient $igdb_client, IgdbGameNormalizer $game_normalizer, Connection $database, StateInterface $state, RequestStack $request_stack) {
    $this->igdbClient = $igdb_client;
    $this->gameNormalizer = $game_normalizer;
    $this->database = $database;
    $this->state = $state;
    $this->requestStack = $request_stack;
  }

  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('igdb_proxy.client'),
      $container->get('igdb_proxy.game_normalizer'),
      $container->get('database'),
      $container->get('state'),
      $container->get('request_stack')
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
    $request = $this->requestStack->getCurrentRequest();
    $live = (bool) $request->query->get('live', false);

    if (!$live) {
      $cached = $this->buildCachedGamesResponse();
      if ($cached !== null) {
        return $cached;
      }
    }

    return $this->buildLiveResponse('games', IgdbFields::GAMES, function (array &$game): void {
      $this->gameNormalizer->normalize($game);
    });
  }

  /**
   * IGDB feed endpoint for Genres.
   *
   * Supports paging:
   *   /igdb/feed/genres?offset=0
   */
  public function genres(): JsonResponse {
    return $this->buildLiveResponse('genres', IgdbFields::GENRES);
  }

  /**
   * IGDB feed endpoint for Platforms.
   *
   * Supports paging:
   *   /igdb/feed/platforms?offset=0
   */
  public function platforms(): JsonResponse {
    return $this->buildLiveResponse('platforms', IgdbFields::PLATFORMS);
  }

  /**
   * Shared IGDB feed handler with paging support for Feeds.
   */
  protected function buildLiveResponse(string $endpoint, string $fields, ?callable $normalizer = null): JsonResponse {
    $request = $this->requestStack->getCurrentRequest();

    $limit = (int) $request->query->get('limit', 50);
    $limit = max(1, min($limit, 500));
    $offset = max(0, (int) $request->query->get('offset', 0));

    $where = $endpoint === 'games' ? 'total_rating > 40' : null;
    $sort = $endpoint === 'games' ? 'id desc' : null;

    $items = $this->igdbClient->query($endpoint, $fields, $offset, $limit, $where, $sort);

    if ($normalizer) {
      foreach ($items as &$item) {
        $normalizer($item);
      }
      unset($item);
    }

    return new JsonResponse([
      'items' => $items,

      // Helpful metadata for debugging / iterating.
      'meta' => [
        'limit' => $limit,
        'next_offset' => $offset + $limit,
        'count' => count($items),
      ],
    ]);
  }

  protected function buildCachedGamesResponse(): ?JsonResponse {
    $request = $this->requestStack->getCurrentRequest();

    $limit = (int) $request->query->get('limit', 500);
    $limit = max(1, min($limit, 500));
    $offset = max(0, (int) $request->query->get('offset', 0));

    $query = $this->database->select('igdb_game_cache', 'g')
      ->fields('g', ['payload'])
      ->orderBy('igdb_id', 'DESC')
      ->range($offset, $limit);

    $items = [];
    foreach ($query->execute() as $row) {
      $payload = json_decode($row->payload, true);
      if (is_array($payload)) {
        $items[] = $payload;
      }
    }

    if (!$items) {
      return null;
    }

    $total = (int) $this->database->select('igdb_game_cache', 'g')
      ->countQuery()
      ->execute()
      ->fetchField();

    return new JsonResponse([
      'items' => $items,
      'meta' => [
        'source' => 'cache',
        'limit' => $limit,
        'next_offset' => $offset + $limit,
        'count' => count($items),
        'total' => $total,
        'last_sync' => (int) $this->state->get('igdb_proxy.games_last_sync', 0),
      ],
    ]);
  }

}
