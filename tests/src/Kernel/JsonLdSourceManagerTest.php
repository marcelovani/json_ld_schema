<?php

namespace Drupal\Tests\json_ld_schema\Kernel;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\KernelTests\KernelTestBase;

/**
 * @coversDefaultClass \Drupal\json_ld_schema\JsonLdSourceManager
 * @group json_ld_schema
 */
class JsonLdSourceManagerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'json_ld_schema_test_sources',
    'json_ld_schema',
  ];

  /**
   * The plugin manager.
   *
   * @var \Drupal\json_ld_schema\JsonLdSourceManager
   */
  protected $pluginManager;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->pluginManager = $this->container->get('plugin.manager.json_ld_schema.source');
  }

  /**
   * @covers ::getCurrentPageData
   */
  public function testCacheabilityMetadataBubbling() {
    $metadata = new CacheableMetadata();
    $this->pluginManager->getCurrentPageData($metadata);

    $build = [];
    $metadata->applyTo($build);
    // Test that each item of cacheability metadata passed to isApplicable and
    // getData is isolated and can't override each others data.
    $this->assertEquals([
      '#cache' => [
        'contexts' => [
          'route',
          'url',
        ],
        'tags' => [
          'bar_tag',
          'foo_tag',
        ],
        'max-age' => -1,
      ],
    ], $build);
  }

  /**
   * @covers ::getCurrentPageData
   */
  public function testGetMultiplePlugins() {
    $data = $this->pluginManager->getCurrentPageData(new CacheableMetadata());
    $this->assertCount(2, $data);
  }

}
