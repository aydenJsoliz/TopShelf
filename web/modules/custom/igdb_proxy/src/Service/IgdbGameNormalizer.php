<?php

namespace Drupal\igdb_proxy\Service;

class IgdbGameNormalizer {

  public function normalize(array &$game): void {
    if (isset($game['cover']['url']) && is_string($game['cover']['url'])) {
      if (str_starts_with($game['cover']['url'], '//')) {
        $game['cover']['url'] = 'https:' . $game['cover']['url'];
      }
      $game['cover']['url'] = str_replace('/t_thumb/', '/t_original/', $game['cover']['url']);
    }
  }

}
