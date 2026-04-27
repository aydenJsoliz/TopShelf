<?php

use Drupal\node\Entity\Node;

$storage = \Drupal::entityTypeManager()->getStorage('node');

$nids = \Drupal::entityQuery('node')
  ->condition('type', 'game')
  ->accessCheck(FALSE)
  ->execute();

$nodes = $storage->loadMultiple($nids);

foreach ($nodes as $node) {
  if ($node->hasField('field_genre') && !$node->get('field_genre')->isEmpty() && $node->get('field_genre_text')->isEmpty()) {
    $genres = [];

    foreach ($node->get('field_genre')->referencedEntities() as $term) {
      $genres[] = $term->label();
    }

    $node->set('field_genre_text', implode(', ', $genres));
    $node->save();

    print "Updated node {$node->id()}\n";
  }
}

