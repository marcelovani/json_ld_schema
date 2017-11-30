<?php

namespace Drupal\json_ld_schema;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\json_ld_schema\Annotation\JsonLdSource;

/**
 * A plugin manager for JsonLdSchema plugins.
 */
class JsonLdSourceManager extends DefaultPluginManager implements JsonLdSourceManagerInterface {

  /**
   * JsonLdSourceManager constructor.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/JsonLdSource', $namespaces, $module_handler, JsonLdSourceInterface::class, JsonLdSource::class);
    $this->alterInfo('json_ld_source_info');
    $this->setCacheBackend($cache_backend, 'json_ld_source_plugins');
  }

  /**
   * {@inheritdoc}
   */
  public function getCurrentPageData(CacheableMetadata $metadata) {
    $page_data = [];
    foreach ($this->getDefinitions() as $definition) {
      /** @var \Drupal\json_ld_schema\JsonLdSourceInterface $source */
      $source = $this->createInstance($definition['id']);

      // Create a metadata object for each method, so settings tags or contexts
      // don't override eachother.
      $is_applicable_cacheability = new CacheableMetadata();
      $data_cacheability = new CacheableMetadata();

      // If a source plugin indicates it is applicable for the current page,
      // add the data to the array.
      if ($source->isApplicable($is_applicable_cacheability)) {
        $page_data[] = $source->getData($data_cacheability);
      }

      // Merge both items of cacheability to passed in object.
      $metadata->addCacheableDependency($data_cacheability);
      $metadata->addCacheableDependency($is_applicable_cacheability);
    }

    return $page_data;
  }

}
