<?php

use Drupal\node\Entity\Node;

$storage = \Drupal::entityTypeManager()->getStorage('node');

$nids = \Drupal::entityQuery('node')
  ->condition('type', 'game')
  ->accessCheck(FALSE)
  ->execute();

$nodes = $storage->loadMultiple($nids);

foreach ($nodes as $node) {
  if ($node->hasField('field_platforms') && !$node->get('field_platforms')->isEmpty() && $node->get('field_platform_text')->isEmpty()) {
    $platforms = [];

    foreach ($node->get('field_platforms')->referencedEntities() as $term) {
      $platforms[] = $term->label();
    }

    $node->set('field_platform_text', implode(', ', $platforms));
    $node->save();

    print "Updated node {$node->id()}\n";
  }
}

