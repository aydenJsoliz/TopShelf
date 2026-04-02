<?php

namespace Drupal\igdb_proxy\Service;

class IgdbGameNormalizer {

  public function normalize(array &$game): void {
    if (isset($game['cover']['url']) && is_string($game['cover']['url'])) {
      $game['cover']['url'] = $this->normalizeImageUrl($game['cover']['url'], true);
    }

    if (!empty($game['screenshots']) && is_array($game['screenshots'])) {
      foreach ($game['screenshots'] as &$screenshot) {
        if (isset($screenshot['url']) && is_string($screenshot['url'])) {
          $screenshot['url'] = $this->normalizeImageUrl($screenshot['url'], false);
        }
      }
      unset($screenshot);
    }
  }

  private function normalizeImageUrl(string $url, bool $use_original): string {
    $normalized = $url;

    if (str_starts_with($normalized, 'https://')) {
      $normalized = substr($normalized, 6);
    } elseif (str_starts_with($normalized, 'http://')) {
      $normalized = substr($normalized, 5);
    } elseif (!str_starts_with($normalized, '//')) {
      return $use_original ? str_replace('/t_thumb/', '/t_original/', $normalized) : $normalized;
    }

    if ($use_original) {
      $normalized = str_replace('/t_thumb/', '/t_original/', $normalized);
    }

    return $normalized;
  }

}
