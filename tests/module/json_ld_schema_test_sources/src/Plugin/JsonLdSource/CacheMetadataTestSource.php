<?php

namespace Drupal\json_ld_schema_test_sources\Plugin\JsonLdSource;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\json_ld_schema\JsonLdSourceBase;
use Spatie\SchemaOrg\Schema;
use Spatie\SchemaOrg\Type;

/**
 * @JsonLdSource(
 *   label = "Cacheability Metadata Test Source",
 *   id = "cache_metadata_test_source",
 * )
 */
class CacheMetadataTestSource extends JsonLdSourceBase {

  /**
   * {@inheritdoc}
   */
  public function getData(CacheableMetadata $cacheability_metadata): Type {
    $cacheability_metadata->setCacheTags(['foo_tag']);
    $cacheability_metadata->setCacheContexts(['url']);
    return Schema::thing()->name('Foo');
  }

  /**
   * {@inheritdoc}
   */
  public function isApplicable(CacheableMetadata $cacheability_metadata) {
    $cacheability_metadata->setCacheTags(['bar_tag']);
    $cacheability_metadata->setCacheContexts(['route']);
    return TRUE;
  }

}
