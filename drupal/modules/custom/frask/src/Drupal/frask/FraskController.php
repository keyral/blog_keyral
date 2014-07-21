<?php

namespace Drupal\frask;

class FraskController {

  // All phrase.
  public function content() {
    $items = array();

    foreach(BingoStorage::getAll() as $name) {
      $items[] = l($name, "bingo/delete/$name");
    }

    return array(
      '#theme' => 'bingo_list',
      '#items' => $items,
      '#attached' => array(
        'css' => array(drupal_get_path('module', 'bingo') . '/css/bingo.module.css'),
      ),
    );
  }

  // Bingo result page.
  public function result() {
    $winner = $this->getWinner();

    // Increment winning count.
    BingoStorage::incrementWinning($winner);

    return array(
      '#theme' => 'bingo_result',
      '#winner' => $winner,
      '#attached' => array(
        'css' => array(drupal_get_path('module', 'bingo') . '/css/bingo.module.css'),
      ),
    );
  }

  // Returns random winner name.
  public function getWinner() {
    $participants = BingoStorage::getAll();

    $winner = $participants[rand(0, count($participants) - 1)];

    return $winner;
  }
}

