<?php

namespace Drupal\metatag_custom_routes\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Metatag custom routes entity.
 *
 * @ConfigEntityType(
 *   id = "metatag_custom_routes",
 *   label = @Translation("Metatag custom routes"),
 *   handlers = {
 *     "storage" = "Drupal\metatag_custom_routes\Storage\MetatagCustomRoutesStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\metatag_custom_routes\MetatagCustomRoutesListBuilder",
 *     "form" = {
 *       "add" = "Drupal\metatag_custom_routes\Form\MetatagCustomRoutesForm",
 *       "edit" = "Drupal\metatag_custom_routes\Form\MetatagCustomRoutesForm",
 *       "delete" = "Drupal\metatag_custom_routes\Form\MetatagCustomRoutesDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "metatag_custom_routes",
 *   admin_permission = "administer meta tags",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   links = {
 *     "canonical" = "/admin/config/search/metatag/custom-routes/{metatag_custom_routes}",
 *     "add-form" = "/admin/config/search/metatag/custom-routes/add",
 *     "edit-form" = "/admin/config/search/metatag/custom-routes/edit/{metatag_custom_routes}",
 *     "delete-form" = "/admin/config/search/metatag/custom-routes/{metatag_custom_routes}/delete",
 *     "collection" = "/admin/config/search/metatag/custom-routes"
 *   }
 * )
 */
class MetatagCustomRoutes extends ConfigEntityBase implements MetatagCustomRoutesInterface {

  /**
   * The Metatag custom routes ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Metatag custom routes label.
   *
   * @var string
   */
  protected $label;

  /**
   * {@inheritdoc}
   */
  public function getMetatags() {
    return $this->get('tags');
  }

  /**
   * {@inheritdoc}
   */
  public function setMetatags(array $metatags) {
    $this->set('tags', $metatags);
  }

}
