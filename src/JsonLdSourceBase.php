<?php

namespace Drupal\json_ld_schema;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Plugin\PluginBase;

/**
 * Base class for JSON source plugins.
 */
abstract class JsonLdSourceBase extends PluginBase implements JsonLdSourceInterface {

  /**
   * {@inheritdoc}
   */
  public function isApplicable(CacheableMetadata $metadata) {
    // Display on every page by default.
    return TRUE;
  }

}
