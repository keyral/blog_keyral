<?php

/**
 * @file
 * Contains \Drupal\search\Form\SearchPageAddForm.
 */

namespace Drupal\search\Form;

/**
 * Provides a form for adding a search page.
 */
class SearchPageAddForm extends SearchPageFormBase {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state, $search_plugin_id = NULL) {
    $this->entity->setPlugin($search_plugin_id);
    $definition = $this->entity->getPlugin()->getPluginDefinition();
    $this->entity->set('label', $definition['title']);
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, array &$form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Add search page');
    return $actions;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, array &$form_state) {
    // If there is no default search page, make the added search the default.
    if (!$this->searchPageRepository->getDefaultSearchPage()) {
      $this->searchPageRepository->setDefaultSearchPage($this->entity);
    }

    parent::save($form, $form_state);

    drupal_set_message($this->t('The %label search page has been added.', array('%label' => $this->entity->label())));
  }

}
