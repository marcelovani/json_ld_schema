<?php

namespace Drupal\Tests\json_ld_schema\Functional;

use Drupal\local_testing\LocalTestingTrait;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\Tests\BrowserTestBase;

/**
 * Test the rendering of JSON LD scripts.
 *
 * @group json_ld_schema
 */
class JsonLdEntityTest extends BrowserTestBase {

  use LocalTestingTrait;

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'json_ld_schema_test_sources',
    'node',
  ];

  /**
   * Test the rendering of JSON LD and the integration with render cache.
   */
  public function testJsonLdEntity() {
    NodeType::create([
      'type' => 'example',
      'label' => 'Example',
    ])->save();

    $node = Node::create([
      'type' => 'example',
      'title' => 'Example Node',
    ]);
    $node->save();

    $this->drupalGet($node->tourl());
    $this->assertContains('"@type":"Brewery","name":"Example Node"', $this->getSession()->getPage()->getHtml());

    // By default the low rating will be displayed.
    $this->assertRating(1);
    // Change the low rating and revisit the page to ensure "1" was render
    // cached.
    $this->setRatingLow(2);
    $this->drupalGet($node->tourl());
    $this->assertRating(1);

    // Since query args were added as cache context, visit the node with the
    // high rating flag set.
    $this->drupalGet($node->tourl(), ['query' => ['star_rating' => 'high']]);
    $this->assertRating(5);
  }

  /**
   * Set the high rating.
   *
   * @param int $rating
   *   The low rating.
   */
  protected function setRatingHigh($rating) {
    \Drupal::state()->set('json_ld_entity_test_rating_high', $rating);
  }

  /**
   * Set the low rating.
   *
   * @param int $rating
   *   The low rating.
   */
  protected function setRatingLow($rating) {
    \Drupal::state()->set('json_ld_entity_test_rating_low', $rating);
  }

  /**
   * Assert the rating that appears on the page.
   *
   * @param int $rating
   *   The rating.
   */
  protected function assertRating($rating) {
    $this->assertContains('{"@type":"AggregateRating","ratingValue":' . $rating . '}', $this->getSession()->getPage()->getHtml());
  }

}
