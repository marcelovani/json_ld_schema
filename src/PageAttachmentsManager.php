<?php

namespace Drupal\json_ld_schema;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Manage attaching JSON LD sources to the current page.
 */
class PageAttachmentsManager implements ContainerInjectionInterface {

  /**
   * @var \Drupal\json_ld_schema\JsonLdSourceManagerInterface
   */
  protected $sourceManager;

  /**
   * PageAttachmentsManager constructor.
   */
  public function __construct(JsonLdSourceManagerInterface $sourceManager) {
    $this->sourceManager = $sourceManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.json_ld_schema.source')
    );
  }

  /**
   * Implements hook_page_attachments.
   */
  public function pageAttachments(&$attachments) {
    $cacheability_metadata = new CacheableMetadata();
    $page_data = $this->sourceManager->getCurrentPageData($cacheability_metadata);

    foreach ($page_data as $i => $page_datum) {
      $attachments['#attached']['html_head']['json_ld_schema_' . $i] = [
        [
          '#type' => 'html_tag',
          '#tag' => 'script',
          '#value' => json_encode($page_datum->toArray(), JSON_UNESCAPED_UNICODE),
          '#attributes' => ['type' => 'application/ld+json'],
        ],
        'json_ld_schema_' . $i,
      ];
    }

    $attachments_cache = CacheableMetadata::createFromRenderArray($attachments);
    $attachments_cache->addCacheableDependency($cacheability_metadata);
    $attachments_cache->applyTo($attachments);
  }

}
