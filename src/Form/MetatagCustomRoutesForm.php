<?php

namespace Drupal\metatag_custom_routes\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\metatag\MetatagManagerInterface;
use Drupal\metatag\MetatagTagPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MetatagCustomRoutesForm.
 */
class MetatagCustomRoutesForm extends EntityForm {

  /**
   * The metatag manager service.
   *
   * @var \Drupal\metatag\MetatagManagerInterface
   */
  protected $metatagManager;

  /**
   * The metatag tag plugin manager.
   *
   * @var \Drupal\metatag\MetatagTagPluginManager
   */
  protected $metatagTagPluginManager;

  /**
   * MetatagCustomRoutesForm constructor.
   *
   * @param \Drupal\metatag\MetatagManagerInterface $metatagManager
   *   The metatag manager service.
   * @param \Drupal\metatag\MetatagTagPluginManager $metatagTagPluginManager
   *   The metatag tag plugin manager.
   */
  public function __construct(
    MetatagManagerInterface $metatagManager,
    MetatagTagPluginManager $metatagTagPluginManager
  ) {
    $this->metatagManager = $metatagManager;
    $this->metatagTagPluginManager = $metatagTagPluginManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('metatag.manager'),
      $container->get('plugin.manager.metatag.tag')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'metatags_custom_routes_form';
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $isNew = $this->entity->isNew();
    $form['label'] = [
      '#type' => 'textfield',
      '#placeholder' => $this->t('Enter a valid route name'),
      '#title' => $this->t('Custom Route'),
      '#required' => TRUE,
      '#default_value' => $this->entity->label(),
      '#description' => $this->t('Please enter a route name or an uri.'),
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\metatag_custom_routes\Entity\MetatagCustomRoutes::load',
      ],
      '#disabled' => !$isNew,
    ];

    $tags = $this->entity->get('tags') ?? [];
    $values = $isNew ? [] : $tags;
    $form += $this->metatagManager->form($values, $form);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $tagValues = $this->getTagValues($this->getTags(), $form_state);

    $this->entity->set('tags', $tagValues);
    $status = $this->entity->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Metatag defaults.', [
          '%label' => $this->entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Metatag defaults.', [
          '%label' => $this->entity->label(),
        ]));
    }
  }

  /**
   * Returns the tag plugin definitions.
   *
   * @return array|mixed[]|null
   *   The definitions.
   */
  private function getTags() {
    return $this->metatagTagPluginManager->getDefinitions();
  }

  /**
   * Returns the values of the meta tags.
   *
   * @param array $tags
   *   An array of tag plugins.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   An array of meta tags and values.
   */
  private function getTagValues(array $tags, FormStateInterface $form_state) {
    $tagValues = [];
    foreach ($tags as $id => $definition) {
      if ($form_state->hasValue($id)) {
        // Some plugins need to process form input before storing it.
        // Hence, we set it and then get it.
        $tag = $this->metatagTagPluginManager->createInstance($id);
        $tag->setValue($form_state->getValue($id));
        if (!empty($tag->value())) {
          $tagValues[$id] = $tag->value();
        }
      }
    }

    return $tagValues;
  }

}
