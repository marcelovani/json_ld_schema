<?php

namespace Drupal\Tests\json_ld_schema\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test the rendering of JSON LD scripts.
 *
 * @group json_ld_schema
 */
class RenderJsonLdScriptTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'json_ld_schema_test_sources',
  ];

  /**
   * Test rendering of the scripts.
   */
  public function testRendering() {
    $this->drupalGet('<front>');
    $html = $this->getSession()->getPage()->getHtml();
    $this->assertContains('<script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"Thing","name":"Foo"}</script>', $html);
    $this->assertContains('<script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"Thing","name":"Bar"}</script>', $html);
    $this->assertNotContains('<script type="application/ld+json">{"@context":"http:\/\/schema.org","@type":"Thing","name":"Baz"}</script>', $html);
  }

}
