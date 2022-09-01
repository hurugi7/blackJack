<?php

require_once(__DIR__ . '/Deck.php');
require_once(__DIR__ . '/TotalPointCalculator.php');

class PlayerCPU extends User
{
  public function action(array $cards, int $totalPoint): int
  {
    while(true) {
      echo $this->name . 'の現在の得点は' . $totalPoint . 'です。' . PHP_EOL;
      $card = $this->drawCard($this->deck);
      $cardSuit = $card->getSuit();
      $cardRank = $card->getRank();
      echo $this->name . 'の引いたカードは' . $cardSuit . 'の' . $cardRank . 'です。' . PHP_EOL;
      $cards[] = $cardRank;
      $totalPoint = $this->totalPointCalculator->calculateTotalPoint($cards);
      if ($totalPoint >= 17) {
        break;
      }
    }
    return $totalPoint;
  }
}
