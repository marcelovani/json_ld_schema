<?php

namespace Drupal\json_ld_schema;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Cache\CacheableMetadata;

/**
 * Interface for the JSON LD Source plugin manager.
 */
interface JsonLdSourceManagerInterface extends PluginManagerInterface {

  /**
   * Get the JSON LD data for the current page.
   *
   * @param \Drupal\Core\Cache\CacheableMetadata $metadata
   *   A passed in metadata object for cacheability metadata.
   *
   * @return \Spatie\SchemaOrg\Type[]
   *   Data that should be displayed on the current page.
   */
  public function getCurrentPageData(CacheableMetadata $metadata);

}
