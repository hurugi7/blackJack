<?php

require_once(__DIR__ . '/Card.php');

class Deck
{
  public array $cards = [];
  private const CARD_RANK = ['A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K'];

  public function __construct()
  {
    foreach (['ハート', 'スペード', 'ダイヤ', 'クラブ'] as $suit) {
      foreach (self::CARD_RANK as $rank) {
        $this->cards[] = new Card($suit, $rank);
      }
    }
  }
}
