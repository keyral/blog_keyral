<?php

/**
 * @file
 * Contains \Drupal\form_test\Form\FormTestGroupDetailsForm.
 */

namespace Drupal\form_test\Form;

use Drupal\Core\Form\FormBase;

/**
 * Builds a simple form to test the #group property on #type 'details'.
 */
class FormTestGroupDetailsForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_test_group_details';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    $form['details'] = array(
      '#type' => 'details',
      '#title' => 'Root element',
      '#open' => TRUE,
    );
    $form['meta'] = array(
      '#type' => 'details',
      '#title' => 'Group element',
      '#open' => TRUE,
      '#group' => 'details',
    );
    $form['meta']['element'] = array(
      '#type' => 'textfield',
      '#title' => 'Nest in details element',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
  }

}
