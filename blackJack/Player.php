<?php

require_once(__DIR__ . '/Deck.php');
require_once(__DIR__ . '/TotalPointCalculator.php');

class Player extends User
{
  public function action(array $cards, int $totalPoint)
  {
    while (true) {
      if ($totalPoint > 21) {
        break;
      } else {
        while (true) {
          echo $this->name . 'の現在の得点は' . $totalPoint . 'です。カードを引きますか？(Y/N)' . PHP_EOL;
          $judge = trim(fgets(STDIN));
          if ($judge == "Y") {
            $card = $this->drawCard($this->deck);
            $cardSuit = $card->getSuit();
            $cardRank = $card->getRank();
            echo $this->name . 'の引いたカードは' . $cardSuit . 'の' . $cardRank . 'です。' . PHP_EOL;
            $cards[] = $cardRank;
            $totalPoint = $this->totalPointCalculator->calculateTotalPoint($cards);
            continue 2;
          } elseif ($judge == "N") {
            break;
          } else {
              echo 'YかNで入力してください。' . PHP_EOL;
              continue;
          }
        }
      }
        break;
    }
      return $totalPoint;
  }
}
