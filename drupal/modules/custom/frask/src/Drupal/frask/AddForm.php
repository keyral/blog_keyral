<?php

namespace Drupal\bingo;

use Drupal\Core\Form\FormInterface;

class AddForm implements FormInterface {
  function getFormID() {
    return 'bingo_add_form';
  }

  /*
   * {@inheritdoc}
   */
  function buildForm(array $form, array &$form_state) {
    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Participant'),
    );

    $form['actions'] = array('#type' => 'actions');

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Add'),
    );

    return $form;
  }

  /*
   * {@inheritdoc}
   */
  function validateForm(array &$form, array &$form_state) {
    $name = $form_state['values']['name'];

    if (empty($name)) {
      form_set_error('name', t('You need the name of the participant. Otherwise how you will identify them?'));
    }
  }

  /*
   * {@inheritdoc}
   */
  function submitForm(array &$form, array &$form_state) {
    $name = $form_state['values']['name'];

    BingoStorage::add($name);

    drupal_set_message(t('Added %name as new participant.', array('%name' => $name)));

    $form_state['redirect'] = 'bingo';
  }
}

