<?php

namespace Drupal\igdb_proxy\Commands;

use Drupal\Core\Queue\QueueFactory;
use Drupal\Core\Queue\QueueWorkerManagerInterface;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\State\StateInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\node\NodeInterface;
use Drush\Commands\DrushCommands;

class IgdbProxyCommands extends DrushCommands {

  protected QueueFactory $queueFactory;
  protected QueueWorkerManagerInterface $queueWorkerManager;
  protected FileSystemInterface $fileSystem;
  protected Connection $database;
  protected EntityTypeManagerInterface $entityTypeManager;
  protected StateInterface $state;
  protected TimeInterface $time;

  public function __construct(QueueFactory $queue_factory, QueueWorkerManagerInterface $queue_worker_manager, FileSystemInterface $file_system, Connection $database, EntityTypeManagerInterface $entity_type_manager, StateInterface $state, TimeInterface $time) {
    parent::__construct();
    $this->queueFactory = $queue_factory;
    $this->queueWorkerManager = $queue_worker_manager;
    $this->fileSystem = $file_system;
    $this->database = $database;
    $this->entityTypeManager = $entity_type_manager;
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
   * @option delta-path Destination for the delta JSON export.
   */
  public function sync(array $options = [
    'page-size' => 500,
    'max-items' => 0,
    'time-limit' => 900,
    'force' => FALSE,
    'export-path' => 'public://igdb/games.json',
    'delta-path' => 'public://igdb/games-delta.json',
  ]): void {
    $page_size = (int) ($options['page-size'] ?? 500);
    $page_size = max(1, min($page_size, 500));
    $max_items = max(0, (int) ($options['max-items'] ?? 0));
    $time_limit = max(0, (int) ($options['time-limit'] ?? 900));
    $force = (bool) ($options['force'] ?? FALSE);
    $export_path = (string) ($options['export-path'] ?? 'public://igdb/games.json');
    $delta_path = (string) ($options['delta-path'] ?? 'public://igdb/games-delta.json');

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
    $this->exportGamesDelta($delta_path);
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

  /**
   * Export a delta JSON file of IGDB games whose used fields differ from nodes.
   */
  protected function exportGamesDelta(string $uri): void {
    $directory = $this->fileSystem->dirname($uri);
    $this->fileSystem->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY | FileSystemInterface::MODIFY_PERMISSIONS);

    if (!is_dir($directory)) {
      if (!mkdir($directory, 0775, true) && !is_dir($directory)) {
        throw new \RuntimeException("Failed to create delta export directory: {$directory}");
      }
    }

    $realpath = $this->fileSystem->realpath($uri);
    if (!$realpath) {
      $realpath = $uri;
    }

    $handle = fopen($realpath, 'wb');
    if (!$handle) {
      throw new \RuntimeException("Failed to open delta export path for writing: {$realpath}");
    }

    $node_index = $this->buildGameNodeIndex();
    $total_nodes = count($node_index);

    $total_cached = (int) $this->database->select('igdb_game_cache', 'g')
      ->countQuery()
      ->execute()
      ->fetchField();

    fwrite($handle, "{\"items\":[");
    $first = TRUE;
    $changed = 0;
    $new = 0;
    $updated = 0;
    $field_counts = [];
    $processed = 0;

    $result = $this->database->select('igdb_game_cache', 'g')
      ->fields('g', ['payload'])
      ->orderBy('igdb_id', 'ASC')
      ->execute();

    foreach ($result as $row) {
      $payload = json_decode($row->payload, true);
      if (!is_array($payload)) {
        continue;
      }

      $processed++;
      $id = (int) ($payload['id'] ?? 0);
      if ($id === 0) {
        continue;
      }

      $payload_compare = $this->normalizePayloadForCompare($payload);
      $node_compare = $node_index[$id] ?? null;

      $diff_fields = $node_compare === null ? ['new'] : $this->diffFields($payload_compare, $node_compare);
      $is_changed = $node_compare === null || !empty($diff_fields);

      if ($is_changed) {
        if ($node_compare === null) {
          $new++;
        }
        else {
          $updated++;
          foreach ($diff_fields as $field) {
            $field_counts[$field] = ($field_counts[$field] ?? 0) + 1;
          }
        }
        unset($payload['updated_at']);
        if (!$first) {
          fwrite($handle, ",");
        }
        fwrite($handle, json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        $first = FALSE;
        $changed++;
      }
    }

    fwrite($handle, "],\"meta\":{");
    $top_field = $this->topChangedField($field_counts);
    $field_counts_json = $this->encodeJsonObject($field_counts);
    fwrite($handle, "\"total_cached\":{$total_cached},\"total_nodes\":{$total_nodes},\"changed\":{$changed},\"new\":{$new},\"updated\":{$updated},\"top_changed_field\":\"{$top_field}\",\"field_counts\":{$field_counts_json},\"processed\":{$processed},\"exported\":{$this->time->getRequestTime()}");
    fwrite($handle, "}}");
    fclose($handle);

    $this->state->set('igdb_proxy.games_last_delta', $this->time->getRequestTime());
    $this->logger()->notice("Exported IGDB games delta JSON to {$uri}.");
    $field_summary = $this->formatFieldCounts($field_counts);
    $this->logger()->notice("Delta summary: changed={$changed}, new={$new}, updated={$updated}, top_field={$top_field}.");
    $this->logger()->notice("Delta field counts: {$field_summary}");
  }

  protected function buildGameNodeIndex(): array {
    $storage = $this->entityTypeManager->getStorage('node');
    $nids = $storage->getQuery()
      ->condition('type', 'game')
      ->accessCheck(FALSE)
      ->execute();

    if (!$nids) {
      return [];
    }

    $index = [];
    $chunks = array_chunk($nids, 50);
    foreach ($chunks as $chunk) {
      $nodes = $storage->loadMultiple($chunk);
      foreach ($nodes as $node) {
        if (!$node instanceof NodeInterface) {
          continue;
        }
        if (!$node->hasField('field_id')) {
          continue;
        }
        $id = (int) ($node->get('field_id')->value ?? 0);
        if ($id === 0) {
          continue;
        }
        $index[$id] = $this->normalizeNodeForCompare($node);
      }
    }

    return $index;
  }

  protected function normalizePayloadForCompare(array $payload): array {
    return [
      'id' => (int) ($payload['id'] ?? 0),
      'name' => $this->normalizeString($payload['name'] ?? ''),
      'summary' => $this->normalizeString($payload['summary'] ?? ''),
      'platforms' => $this->normalizeNameList($this->extractNameList($payload['platforms'] ?? [])),
      'companies' => $this->normalizeNameList($this->extractCompanyNameList($payload['involved_companies'] ?? [])),
    ];
  }

  protected function normalizeNodeForCompare(NodeInterface $node): array {
    return [
      'id' => $node->hasField('field_id') ? (int) ($node->get('field_id')->value ?? 0) : 0,
      'name' => $this->normalizeString($node->label() ?? ''),
      'summary' => $this->normalizeString($node->hasField('field_game_description') ? ($node->get('field_game_description')->value ?? '') : ''),
      'platforms' => $this->normalizeNameList($node->hasField('field_platforms') ? $this->extractTermNameList($node->get('field_platforms')) : []),
      'companies' => $this->normalizeNameList($node->hasField('field_devs_and_pubs') ? $this->extractTextList($node->get('field_devs_and_pubs')) : []),
    ];
  }

  protected function diffFields(array $payload, array $node): array {
    $diff = [];
    if ($payload['id'] !== $node['id']) {
      $diff[] = 'id';
    }
    if ($payload['name'] !== $node['name']) {
      $diff[] = 'name';
    }
    if ($payload['summary'] !== $node['summary']) {
      $diff[] = 'summary';
    }
    if ($payload['platforms'] !== $node['platforms']) {
      $diff[] = 'platforms';
    }
    if ($payload['companies'] !== $node['companies']) {
      $diff[] = 'companies';
    }

    return $diff;
  }

  protected function topChangedField(array $field_counts): string {
    if (!$field_counts) {
      return '';
    }
    arsort($field_counts);
    return (string) array_key_first($field_counts);
  }

  protected function formatFieldCounts(array $field_counts): string {
    if (!$field_counts) {
      return '';
    }
    arsort($field_counts);
    $parts = [];
    foreach ($field_counts as $field => $count) {
      $parts[] = "{$field}={$count}";
    }
    return implode(', ', $parts);
  }

  protected function encodeJsonObject(array $data): string {
    if (!$data) {
      return '{}';
    }
    return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: '{}';
  }

  protected function normalizeString(string $value): string {
    $value = trim($value);
    if ($value === '') {
      return '';
    }
    return preg_replace('/\s+/', ' ', $value);
  }

  protected function extractNameList(array $items): array {
    $names = [];
    foreach ($items as $item) {
      if (is_array($item) && isset($item['name'])) {
        $names[] = (string) $item['name'];
      }
    }
    return $names;
  }

  protected function extractCompanyNameList(array $items): array {
    $names = [];
    foreach ($items as $item) {
      if (!is_array($item)) {
        continue;
      }
      $company = $item['company'] ?? null;
      if (is_array($company) && isset($company['name'])) {
        $names[] = (string) $company['name'];
      }
    }
    return $names;
  }

  protected function normalizeNameList(array $names): array {
    $normalized = [];
    foreach ($names as $name) {
      $name = strtolower(trim((string) $name));
      if ($name !== '') {
        $normalized[] = $name;
      }
    }
    sort($normalized, SORT_STRING);
    return $normalized;
  }

  protected function extractTermNameList(FieldItemListInterface $field): array {
    $names = [];
    foreach ($field as $item) {
      if ($item->entity) {
        $names[] = $item->entity->label();
      }
    }
    return $names;
  }

  protected function extractTextList(FieldItemListInterface $field): array {
    $values = [];
    foreach ($field->getValue() as $item) {
      $value = $item['value'] ?? '';
      if ($value === '') {
        continue;
      }
      foreach (explode(',', $value) as $part) {
        $part = trim($part);
        if ($part !== '') {
          $values[] = $part;
        }
      }
    }
    return $values;
  }

}
