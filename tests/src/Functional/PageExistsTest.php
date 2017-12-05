<?php

namespace Drupal\Tests\metatag_custom_routes\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;

/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group metatag_custom_routes
 */
class PageExistsTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['metatag_custom_routes'];

  /**
   * A user with permission to administer site configuration.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->user = $this->drupalCreateUser(['administer meta tags']);
    $this->drupalLogin($this->user);
  }

  /**
   * Tests that the custom routes page loads with a 200 response.
   */
  public function testCustomRoutesCollectionPage() {
    $this->drupalGet(Url::fromRoute('entity.metatag_custom_routes.collection'));
    $this->assertSession()->statusCodeEquals(200);
  }

}
