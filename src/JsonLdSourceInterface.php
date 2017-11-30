<?php

namespace Drupal\json_ld_schema;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Cache\CacheableMetadata;
use Spatie\SchemaOrg\Type;

/**
 * Interface for JSON LD source plugins.
 */
interface JsonLdSourceInterface extends PluginInspectionInterface {

  /**
   * Get data provided by this plugin.
   *
   * @param \Drupal\Core\Cache\CacheableMetadata $cacheability_metadata
   *   The cacheability metadata.
   *
   * @return \Spatie\SchemaOrg\Type
   *   Some schema data.
   */
  public function getData(CacheableMetadata $cacheability_metadata) : Type;

  /**
   * Check if the data for the plugin should appear for the current page.
   *
   * @param \Drupal\Core\Cache\CacheableMetadata $cacheability_metadata
   *   The cacheability metadata.
   *
   * @return bool
   *   If the data returned by the plugin should appear for the current page.
   */
  public function isApplicable(CacheableMetadata $cacheability_metadata);

}
