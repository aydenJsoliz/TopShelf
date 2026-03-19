<?php

namespace Drupal\igdb_proxy\Service;

use Drupal\Core\Site\Settings;
use Drupal\Core\State\StateInterface;
use GuzzleHttp\ClientInterface;

class IgdbClient {

  protected ClientInterface $httpClient;
  protected StateInterface $state;

  public function __construct(ClientInterface $http_client, StateInterface $state) {
    $this->httpClient = $http_client;
    $this->state = $state;
  }

  public function query(string $endpoint, string $fields, int $offset = 0, int $limit = 50, ?string $where = null, ?string $sort = null): array {
    $token = $this->getTwitchToken();

    $query_parts = [
      "fields\n{$fields};",
      "limit {$limit};",
      "offset {$offset};",
    ];

    if ($where) {
      $query_parts[] = "where {$where};";
    }
    if ($sort) {
      $query_parts[] = "sort {$sort};";
    }

    $query = implode("\n", $query_parts) . "\n";

    $response = $this->httpClient->post("https://api.igdb.com/v4/{$endpoint}", [
      'headers' => [
        'Client-ID' => Settings::get('igdb_client_id'),
        'Authorization' => "Bearer {$token}",
        'Accept' => 'application/json',
      ],
      'body' => $query,
      'timeout' => 30,
    ]);

    $data = json_decode($response->getBody()->getContents(), true);
    return is_array($data) ? $data : [];
  }

  protected function getTwitchToken(): string {
    $token = $this->state->get('igdb.token');
    $expires = (int) $this->state->get('igdb.token_expires', 0);

    if ($token && $expires > (time() + 60)) {
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
    $access_token = $data['access_token'] ?? '';
    $expires_in = (int) ($data['expires_in'] ?? 0);

    if ($access_token) {
      $this->state->set('igdb.token', $access_token);
      $this->state->set('igdb.token_expires', time() + $expires_in);
    }

    return $access_token;
  }

}
