<?php

namespace Drupal\igdb_proxy;

class IgdbFields {

  public const GAMES = <<<FIELDS
  id,
  name,
  summary,
  first_release_date,
  total_rating,
  parent_game,
  screenshots.url,
  cover.url,
  platforms.name,
  genres.name,
  involved_companies.company.name
FIELDS;

  public const GENRES = <<<FIELDS
  name
FIELDS;

  public const PLATFORMS = <<<FIELDS
  name
FIELDS;

}
