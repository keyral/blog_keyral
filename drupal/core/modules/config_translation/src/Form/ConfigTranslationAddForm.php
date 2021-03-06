<?php

/**
 * @file
 * Contains \Drupal\config_translation\Form\ConfigTranslationAddForm.
 */

namespace Drupal\config_translation\Form;

use Symfony\Component\HttpFoundation\Request;

/**
 * Defines a form for adding configuration translations.
 */
class ConfigTranslationAddForm extends ConfigTranslationFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_translation_add_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state, Request $request = NULL, $plugin_id = NULL, $langcode = NULL) {
    $form = parent::buildForm($form, $form_state, $request, $plugin_id, $langcode);
    $form['#title'] = $this->t('Add @language translation for %label', array(
      '%label' => $this->mapper->getTitle(),
      '@language' => $this->language->name,
    ));
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    parent::submitForm($form, $form_state);
    drupal_set_message($this->t('Successfully saved @language translation.', array('@language' => $this->language->name)));
  }

}
