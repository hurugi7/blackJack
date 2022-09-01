<?php

class Game
{
  public function start(Deck $deck, Player $player, Dealer $dealer, TotalPointCalculator $totalPointCalculator, int $playerNum)
  {
    echo 'ブラックジャックを始めます。' . PHP_EOL;

    for ($i = 1; $i <= $playerNum; $i++) {
      $playerCards[$i] = [$player->drawCard($deck), $player->drawCard($deck)];
    }

    echo 'あなたの引いたカードは' . $playerCards[1][0]->getSuit() . 'の' . $playerCards[1][0]->getRank() . 'です。' . PHP_EOL;
    echo 'あなたの引いたカードは' . $playerCards[1][1]->getSuit() . 'の' . $playerCards[1][1] . 'です。' . PHP_EOL;

    if ($playerNum >= 2) {
      for ($i = 2; $i <= $playerNum; $i++) {
        echo 'プレイヤー'. $i . 'の引いたカードは' . $playerCards[1][0]->getSuit() . 'の' . $playerCards[1][0]->getRank() . 'です。' . PHP_EOL;
        echo 'プレイヤー'. $i .'の引いたカードは' . $playerCards[1][1]->getSuit() . 'の' . $playerCards[1][1] . 'です。' . PHP_EOL;
      }
    }

    $dealerCard1 = $dealer->drawCard($deck);
    $dealerCard2 = $dealer->drawCard($deck);
    echo 'ディーラーの引いたカードは' . $dealerCard1->getSuit() . 'の' . $dealerCard1->getRank() . 'です。' . PHP_EOL;
    echo 'ディーラーの引いた2枚目のカードはわかりません。' . PHP_EOL;

    $playerCards = [$playerCard1->getRank(), $playerCard2->getRank()];
    $dealerCards = [$dealerCard1->getRank(), $dealerCard2->getRank()];
    $playerTotalPoint = $totalPointCalculator->calculateTotalPoint($playerCards);
    $dealerTotalPoint = $totalPointCalculator->calculateTotalPoint($dealerCards);
  }
}
