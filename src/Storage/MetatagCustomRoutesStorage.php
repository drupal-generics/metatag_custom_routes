<?php

namespace Drupal\metatag_custom_routes\Storage;

use Drupal\Core\Config\Entity\ConfigEntityStorage;

/**
 * Class MetatagCustomRoutesStorage.
 *
 * @package Drupal\metatag_custom_routes\Storage
 */
class MetatagCustomRoutesStorage extends ConfigEntityStorage {

  /**
   * Loads the entity by route name.
   *
   * @param string $routeName
   *   The name of the current route.
   *
   * @return \Drupal\Core\Entity\EntityInterface|mixed|null
   *   The entity if it exists.
   */
  public function loadEntityByRouteName(string $routeName) {
    $entities = $this->loadByProperties(['label' => $routeName]);

    return $entities ? reset($entities) : NULL;
  }

  /**
   * Loads the entity by request URI.
   *
   * @param string $uri
   *   The uri.
   *
   * @return \Drupal\Core\Entity\EntityInterface|mixed|null
   *   The entity if it exists.
   */
  public function loadEntityByUri(string $uri) {
    /** @var \Drupal\metatag_custom_routes\MetatagCustomRoutesHelper $helper */
    $helper = \Drupal::service('metatag_custom_routes.routes_helper');

    $id = $helper->transformUriToEntityId($uri);

    return $this->load($id);
  }

}
