<?php

namespace Drupal\json_ld_schema_test_sources\Plugin\JsonLdSource;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\json_ld_schema\JsonLdSourceBase;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;

/**
 * Generic test source.
 *
 * @JsonLdSource(
 *   label = "Generic Test Source",
 *   id = "generic_test_source",
 * )
 */
class GenericTestSource extends JsonLdSourceBase {

  /**
   * {@inheritdoc}
   */
  public function getData(): Type {
    return Schema::thing()->name('Bar');
  }

}
