<?php

namespace Drupal\Tests\metatag_custom_routes\Unit;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Tests\UnitTestCase;

/**
 * Class MetatagCustomRoutesHelperTest.
 *
 * @package Drupal\Tests\metatag_custom_routes\Unit
 */
class MetatagCustomRoutesHelperTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $container = new ContainerBuilder();

    // Sets up the transliteration service.
    $transliteration = $this->getMockBuilder('Drupal\Core\Transliteration\PhpTransliteration')
      ->disableOriginalConstructor()
      ->setMethods(['transliterate'])
      ->getMock();

    // During the test PHPUnit expects that the 'transliterate' method of the
    // mock service defined above to be called only once and to return the
    // value '/user/register'.
    $transliteration->expects($this->once())
      ->method('transliterate')
      ->will($this->returnValue('/user/register'));

    $container->set('transliterate', $transliteration);

    // Mocks the helper service that we are testing.
    $customRoutesHelper = $this->getMockBuilder('\Drupal\metatag_custom_routes\MetatagCustomRoutesHelper')
      ->setConstructorArgs([$transliteration])
    // This method makes sure that the actual code from the methods are called.
      ->setMethods(NULL)
      ->getMock();

    $container->set('metatag_custom_routes.routes_helper', $customRoutesHelper);

    \Drupal::setContainer($container);
  }

  /**
   * Tests the transformUriToEntityId method.
   *
   * @see MetatagCustomRoutesHelper::transformUriToEntityId()
   */
  public function testTransformUriToEntityId() {
    $metatagCustomRoutesHelper = \Drupal::service('metatag_custom_routes.routes_helper');
    $actual = $metatagCustomRoutesHelper->transformUriToEntityId('/user/register');
    $this->assertEquals('_user_register', $actual);
  }

}
