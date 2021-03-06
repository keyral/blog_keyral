<?php

/**
 * @file
 * Contains \Drupal\form_test\Form\FormTestFormStateValuesCleanAdvancedForm.
 */

namespace Drupal\form_test\Form;

use Drupal\Core\Form\FormBase;

/**
 * Form builder for form_state_values_clean() test.
 */
class FormTestFormStateValuesCleanAdvancedForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_test_form_state_values_clean_advanced_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    // Build an example form containing a managed file and a submit form element.
    $form['image'] = array(
      '#type' => 'managed_file',
      '#title' => t('Image'),
      '#upload_location' => 'public://',
      '#default_value' => 0,
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    form_state_values_clean($form_state);
    print t('You WIN!');
    exit;
  }

}
