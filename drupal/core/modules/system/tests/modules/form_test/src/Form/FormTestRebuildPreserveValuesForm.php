<?php

/**
 * @file
 * Contains \Drupal\form_test\Form\FormTestRebuildPreserveValuesForm.
 */

namespace Drupal\form_test\Form;

use Drupal\Core\Form\FormBase;

/**
 * Form builder for testing preservation of values during a rebuild.
 */
class FormTestRebuildPreserveValuesForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_test_form_rebuild_preserve_values_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    // Start the form with two checkboxes, to test different defaults, and a
    // textfield, to test more than one element type.
    $form = array(
      'checkbox_1_default_off' => array(
        '#type' => 'checkbox',
        '#title' => t('This checkbox defaults to unchecked.'),
        '#default_value' => FALSE,
      ),
      'checkbox_1_default_on' => array(
        '#type' => 'checkbox',
        '#title' => t('This checkbox defaults to checked.'),
        '#default_value' => TRUE,
      ),
      'text_1' => array(
        '#type' => 'textfield',
        '#title' => t('This textfield has a non-empty default value.'),
        '#default_value' => 'DEFAULT 1',
      ),
    );
    // Provide an 'add more' button that rebuilds the form with an additional two
    // checkboxes and a textfield. The test is to make sure that the rebuild
    // triggered by this button preserves the user input values for the initial
    // elements and initializes the new elements with the correct default values.
    if (empty($form_state['storage']['add_more'])) {
      $form['add_more'] = array(
        '#type' => 'submit',
        '#value' => 'Add more',
        '#submit' => array(array($this, 'addMoreSubmitForm')),
      );
    }
    else {
      $form += array(
        'checkbox_2_default_off' => array(
          '#type' => 'checkbox',
          '#title' => t('This checkbox defaults to unchecked.'),
          '#default_value' => FALSE,
        ),
        'checkbox_2_default_on' => array(
          '#type' => 'checkbox',
          '#title' => t('This checkbox defaults to checked.'),
          '#default_value' => TRUE,
        ),
        'text_2' => array(
          '#type' => 'textfield',
          '#title' => t('This textfield has a non-empty default value.'),
          '#default_value' => 'DEFAULT 2',
        ),
      );
    }
    // A submit button that finishes the form workflow (does not rebuild).
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => 'Submit',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function addMoreSubmitForm(array &$form, array &$form_state) {
    // Rebuild, to test preservation of input values.
    $form_state['storage']['add_more'] = TRUE;
    $form_state['rebuild'] = TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    // Finish the workflow. Do not rebuild.
    drupal_set_message(t('Form values: %values', array('%values' => var_export($form_state['values'], TRUE))));
  }

}
