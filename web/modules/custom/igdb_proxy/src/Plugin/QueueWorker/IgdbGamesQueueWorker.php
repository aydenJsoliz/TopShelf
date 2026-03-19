<?php

namespace Drupal\igdb_proxy\Plugin\QueueWorker;

use Drupal\Core\Database\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\Core\State\StateInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\igdb_proxy\IgdbFields;
use Drupal\igdb_proxy\Service\IgdbClient;
use Drupal\igdb_proxy\Service\IgdbGameNormalizer;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Processes IGDB game sync in small chunks to avoid timeouts.
 *
 * @QueueWorker(
 *   id = "igdb_proxy_games",
 *   title = @Translation("IGDB games sync"),
 *   cron = {"time" = 20}
 * )
 */
class IgdbGamesQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {

  protected Connection $database;
  protected QueueFactory $queueFactory;
  protected StateInterface $state;
  protected TimeInterface $time;
  protected IgdbClient $igdbClient;
  protected IgdbGameNormalizer $gameNormalizer;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database, QueueFactory $queue_factory, StateInterface $state, TimeInterface $time, IgdbClient $igdb_client, IgdbGameNormalizer $game_normalizer) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
    $this->queueFactory = $queue_factory;
    $this->state = $state;
    $this->time = $time;
    $this->igdbClient = $igdb_client;
    $this->gameNormalizer = $game_normalizer;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database'),
      $container->get('queue'),
      $container->get('state'),
      $container->get('datetime.time'),
      $container->get('igdb_proxy.client'),
      $container->get('igdb_proxy.game_normalizer')
    );
  }

  public function processItem($data): void {
    $offset = (int) ($data['offset'] ?? 0);
    $limit = (int) ($data['limit'] ?? 500);
    if ($limit < 1 || $limit > 500) {
      $limit = 500;
    }

    $games = $this->igdbClient->query(
      'games',
      IgdbFields::GAMES,
      $offset,
      $limit,
      'total_rating > 40',
      'id desc'
    );

    foreach ($games as &$game) {
      $this->gameNormalizer->normalize($game);
    }
    unset($game);

    if ($games) {
      $now = $this->time->getRequestTime();
      $upsert = $this->database->upsert('igdb_game_cache')
        ->key('igdb_id')
        ->fields(['igdb_id', 'payload', 'updated']);

      foreach ($games as $game) {
        $upsert->values([
          'igdb_id' => (int) ($game['id'] ?? 0),
          'payload' => json_encode($game, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
          'updated' => $now,
        ]);
      }

      $upsert->execute();
    }

    $queue = $this->queueFactory->get('igdb_proxy_games');
    if (count($games) === $limit) {
      $queue->createItem([
        'offset' => $offset + $limit,
        'limit' => $limit,
      ]);
    }
    else {
      $this->state->set('igdb_proxy.games_last_sync', $this->time->getRequestTime());
    }
  }

}
