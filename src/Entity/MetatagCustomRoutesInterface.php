<?php

namespace Drupal\metatag_custom_routes\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface for defining Metatag custom routes entities.
 */
interface MetatagCustomRoutesInterface extends ConfigEntityInterface {

  /**
   * Returns a list of meta tags.
   *
   * @return array
   *   The list of tags.
   */
  public function getMetatags();

  /**
   * Sets the tags property of the entity.
   *
   * @param array $metatags
   *   An array of metatags that is set.
   */
  public function setMetatags(array $metatags);

}
