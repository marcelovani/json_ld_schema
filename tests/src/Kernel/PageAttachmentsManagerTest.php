<?php

namespace Drupal\Tests\json_ld_schema\Kernel;

use Drupal\json_ld_schema\PageAttachmentsManager;
use Drupal\KernelTests\KernelTestBase;

/**
 * @coversDefaultClass \Drupal\json_ld_schema\PageAttachmentsManager
 * @group json_ld_schema
 */
class PageAttachmentsManagerTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'json_ld_schema_test_sources',
    'json_ld_schema',
  ];

  /**
   * The attachments manager.
   *
   * @var \Drupal\json_ld_schema\PageAttachmentsManager
   */
  protected $attachmentsManager;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->attachmentsManager = $this->container->get('class_resolver')->getInstanceFromDefinition(PageAttachmentsManager::class);
  }

  /**
   * @covers ::pageAttachments
   */
  public function testPageAttachments() {
    $attachments = [
      '#attached' => [
        'foo' => 'bar',
      ],
      '#cache' => [
        'tags' => ['foo'],
      ],
    ];
    $this->attachmentsManager->pageAttachments($attachments);

    // Ensure existing data in the attachments array is preserved.
    $this->assertEquals($attachments['#attached']['foo'], 'bar');
    $this->assertTrue(in_array('foo', $attachments['#cache']['tags']));

    // Ensure the new stuff is added.
    $this->assertEquals('script', $attachments['#attached']['html_head']['json_ld_schema_0'][0]['#tag']);
    $this->assertEquals('script', $attachments['#attached']['html_head']['json_ld_schema_1'][0]['#tag']);
  }

}
