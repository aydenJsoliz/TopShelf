<?php

namespace Drupal\igdb_proxy\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Core\State\StateInterface;

class IgdbProxyController extends ControllerBase {

  protected ClientInterface $httpClient;
  protected StateInterface $state;

  public function __construct(ClientInterface $http_client, StateInterface $state) {
    $this->httpClient = $http_client;
    $this->state = $state;
  }

  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('http_client'),
      $container->get('state')
    );
  }

  /**
   * IGDB feed endpoint for Feeds.
   */
  public function games(): JsonResponse {
    $token = $this->getTwitchToken();

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
limit 500;
sort first_release_date desc;
IGDB;

    $response = $this->httpClient->post('https://api.igdb.com/v4/games', [
      'headers' => [
        'Client-ID' => $_ENV['IGDB_CLIENT_ID'],
        'Authorization' => "Bearer {$token}",
      ],
      'body' => $query,
    ]);

    $games = json_decode($response->getBody()->getContents(), true);

    return new JsonResponse([
      'items' => $games,
    ]);
  }

  /**
   * Get or refresh Twitch OAuth token.
   */
  protected function getTwitchToken(): string {
    if ($token = $this->state->get('igdb.token')) {
      return $token;
    }

    $response = $this->httpClient->post('https://id.twitch.tv/oauth2/token', [
      'query' => [
        'client_id' => $_ENV['IGDB_CLIENT_ID'],
        'client_secret' => $_ENV['IGDB_CLIENT_SECRET'],
        'grant_type' => 'client_credentials',
      ],
    ]);

    $data = json_decode($response->getBody(), true);
    $this->state->set('igdb.token', $data['access_token']);

    return $data['access_token'];
  }
}