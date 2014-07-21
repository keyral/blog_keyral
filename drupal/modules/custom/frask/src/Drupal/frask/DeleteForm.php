<?php

namespace Drupal\bingo;

use Drupal\Core\Form\ConfirmFormBase;

class DeleteForm extends ConfirmFormBase {
  protected $name;

  /*
   * {@inheritdoc}
   */
  function getFormID() {
    return 'bingo_delete_form';
  }

  /*
   * {@inheritdoc}
   */
  function getQuestion() {
    return t('Are you sure you want to delete participant %name', array('%name' => $this->name));
  }

  /*
   * {@inheritdoc}
   */
  function getConfirmText() {
    return t('Delete');
  }

  /*
   * {@inheritdoc}
   */
  function getCancelRoute() {
    return array(
      'route_name' => 'bingo'
    );
  }

  /*
   * {@inheritdoc}
   */
  function buildForm(array $form, array &$form_state, $name = '') {
    $this->name = $name;

    return parent::buildForm($form, $form_state);
  }

  /*
   * {@inheritdoc}
   */
  function submitForm(array &$form, array &$form_state) {
    BingoStorage::delete($this->name);

    drupal_set_message(t('Participant %name deleted.', array('%name' => $this->name)));
      watchdog('lol', 'Error');

    $form_state['redirect'] = 'bingo';
  }
}

