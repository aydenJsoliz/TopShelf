<?php

namespace Drupal\igdb_proxy\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\State\StateInterface;
use Drupal\igdb_proxy\IgdbFields;
use Drupal\igdb_proxy\Service\IgdbClient;
use Drupal\igdb_proxy\Service\IgdbGameNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;

class IgdbProxyController extends ControllerBase {

  protected IgdbClient $igdbClient;
  protected IgdbGameNormalizer $gameNormalizer;
  protected FileSystemInterface $fileSystem;
  protected StateInterface $state;
  protected RequestStack $requestStack;

  public function __construct(IgdbClient $igdb_client, IgdbGameNormalizer $game_normalizer, FileSystemInterface $file_system, StateInterface $state, RequestStack $request_stack) {
    $this->igdbClient = $igdb_client;
    $this->gameNormalizer = $game_normalizer;
    $this->fileSystem = $file_system;
    $this->state = $state;
    $this->requestStack = $request_stack;
  }

  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('igdb_proxy.client'),
      $container->get('igdb_proxy.game_normalizer'),
      $container->get('file_system'),
      $container->get('state'),
      $container->get('request_stack')
    );
  }

  /**
   * IGDB feed endpoint for Feeds.
   *
   * Returns games updated since the last successful pull (stored in state).
   * Supports paging:
   *   /igdb/feed/games?offset=0
   *   /igdb/feed/games?offset=500
   */
  public function games(): JsonResponse {
    $request = $this->requestStack->getCurrentRequest();

    $limit = (int) $request->query->get('limit', 500);
    $limit = max(1, min($limit, 500));
    $offset = max(0, (int) $request->query->get('offset', 0));

    $last_pull = (int) $this->state->get('igdb_proxy.games_last_pull', 0);
    $where = "updated_at > {$last_pull}";
    $items = $this->igdbClient->query('games', IgdbFields::GAMES, $offset, $limit, $where, 'updated_at asc');

    foreach ($items as &$item) {
      $this->gameNormalizer->normalize($item);
    }
    unset($item);

    $max_updated_at = $last_pull;
    $min_updated_at = 0;
    foreach ($items as $item) {
      $updated_at = (int) ($item['updated_at'] ?? 0);
      if ($min_updated_at === 0 || ($updated_at > 0 && $updated_at < $min_updated_at)) {
        $min_updated_at = $updated_at;
      }
      if ($updated_at > $max_updated_at) {
        $max_updated_at = $updated_at;
      }
    }

    if (count($items) < $limit && $max_updated_at > $last_pull) {
      // Only advance the watermark after the final page.
      $this->state->set('igdb_proxy.games_last_pull', $max_updated_at);
    }

    return new JsonResponse([
      'items' => $items,
      'meta' => [
        'limit' => $limit,
        'next_offset' => $offset + $limit,
        'count' => count($items),
        'since' => $last_pull,
        'updated_min' => $min_updated_at,
        'updated_max' => $max_updated_at,
      ],
    ]);
  }

  /**
   * Serve the games delta JSON file.
   */
  public function gamesDelta(): Response {
    $path = 'public://igdb/games-delta.json';
    $realpath = $this->fileSystem->realpath($path);

    if (!$realpath || !is_readable($realpath)) {
      return new JsonResponse([
        'error' => 'Delta file not found.',
        'path' => $path,
      ], 404);
    }

    $contents = file_get_contents($realpath);
    if ($contents === false) {
      return new JsonResponse([
        'error' => 'Failed to read delta file.',
        'path' => $path,
      ], 500);
    }

    return new Response($contents, 200, [
      'Content-Type' => 'application/json',
    ]);
  }

}
