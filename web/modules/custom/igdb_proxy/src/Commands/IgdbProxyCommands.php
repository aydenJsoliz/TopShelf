<?php

namespace Drupal\igdb_proxy\Commands;

use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Queue\QueueWorkerManagerInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\State\StateInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drush\Commands\DrushCommands;

class IgdbProxyCommands extends DrushCommands {

  protected QueueFactory $queueFactory;
  protected QueueWorkerManagerInterface $queueWorkerManager;
  protected FileSystemInterface $fileSystem;
  protected Connection $database;
  protected StateInterface $state;
  protected TimeInterface $time;

  public function __construct(QueueFactory $queue_factory, QueueWorkerManagerInterface $queue_worker_manager, FileSystemInterface $file_system, Connection $database, StateInterface $state, TimeInterface $time) {
    parent::__construct();
    $this->queueFactory = $queue_factory;
    $this->queueWorkerManager = $queue_worker_manager;
    $this->fileSystem = $file_system;
    $this->database = $database;
    $this->state = $state;
    $this->time = $time;
  }

  /**
   * Enqueue and process the IGDB games sync queue.
   *
   * @command igdb:sync
   * @aliases igdb-sync
   *
   * @option page-size Page size for IGDB requests (1-500). Default: 500.
   * @option max-items Max queue items to process (0 = no limit). Default: 0.
   * @option time-limit Max seconds to process queue (0 = no limit). Default: 900.
   * @option force Enqueue a new full sync even if one recently ran.
   * @option export-path Destination for the JSON export. Default: public://igdb/games.json.
   */
  public function sync(array $options = [
    'page-size' => 500,
    'max-items' => 0,
    'time-limit' => 900,
    'force' => FALSE,
    'export-path' => 'public://igdb/games.json',
  ]): void {
    $page_size = (int) ($options['page-size'] ?? 500);
    $page_size = max(1, min($page_size, 500));
    $max_items = max(0, (int) ($options['max-items'] ?? 0));
    $time_limit = max(0, (int) ($options['time-limit'] ?? 900));
    $force = (bool) ($options['force'] ?? FALSE);
    $export_path = (string) ($options['export-path'] ?? 'public://igdb/games.json');

    $queue = $this->queueFactory->get('igdb_proxy_games');
    $last_sync = (int) $this->state->get('igdb_proxy.games_last_sync', 0);
    $now = $this->time->getRequestTime();

    if ($force || ($now - $last_sync) >= 86400) {
      if ($queue->numberOfItems() === 0) {
        $queue->createItem([
          'offset' => 0,
          'limit' => $page_size,
        ]);
        $this->logger()->notice('IGDB sync queued.');
      }
      else {
        $this->logger()->notice('IGDB sync already queued.');
      }
    }
    else {
      $this->logger()->notice('IGDB sync skipped (last sync within 24 hours). Use --force to override.');
    }

    $worker = $this->queueWorkerManager->createInstance('igdb_proxy_games');
    $processed = 0;
    $start = $this->time->getRequestTime();

    while ($item = $queue->claimItem()) {
      try {
        $worker->processItem($item->data);
        $queue->deleteItem($item);
        $processed++;
      }
      catch (\Throwable $e) {
        $queue->releaseItem($item);
        throw $e;
      }

      if ($max_items > 0 && $processed >= $max_items) {
        break;
      }

      if ($time_limit > 0 && ($this->time->getRequestTime() - $start) >= $time_limit) {
        break;
      }
    }

    $this->logger()->notice("Processed {$processed} queue item(s). Remaining: {$queue->numberOfItems()}.");

    $this->exportGamesJson($export_path);
  }

  protected function exportGamesJson(string $uri): void {
    $directory = $this->fileSystem->dirname($uri);
    $this->fileSystem->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS);

    $realpath = $this->fileSystem->realpath($uri);
    if (!$realpath) {
      throw new \RuntimeException("Failed to resolve export path: {$uri}");
    }

    $handle = fopen($realpath, 'wb');
    if (!$handle) {
      throw new \RuntimeException("Failed to open export path for writing: {$realpath}");
    }

    $total = (int) $this->database->select('igdb_game_cache', 'g')
      ->countQuery()
      ->execute()
      ->fetchField();

    $last_sync = (int) $this->state->get('igdb_proxy.games_last_sync', 0);

    fwrite($handle, "{\"items\":[");
    $first = TRUE;

    $result = $this->database->select('igdb_game_cache', 'g')
      ->fields('g', ['payload'])
      ->orderBy('igdb_id', 'DESC')
      ->execute();

    foreach ($result as $row) {
      $payload = trim((string) $row->payload);
      if ($payload === '') {
        continue;
      }

      if (!$first) {
        fwrite($handle, ",");
      }
      fwrite($handle, $payload);
      $first = FALSE;
    }

    fwrite($handle, "],\"meta\":{");
    fwrite($handle, "\"total\":{$total},\"last_sync\":{$last_sync},\"exported\":{$this->time->getRequestTime()}");
    fwrite($handle, "}}");
    fclose($handle);

    $this->state->set('igdb_proxy.games_last_export', $this->time->getRequestTime());
    $this->logger()->notice("Exported IGDB games JSON to {$uri}.");
  }

}
