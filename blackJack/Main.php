<?php

require_once(__DIR__ . '/Card.php');
require_once(__DIR__ . '/User.php');
require_once(__DIR__ . '/Deck.php');
require_once(__DIR__ . '/Dealer.php');
require_once(__DIR__ . '/Player.php');
require_once(__DIR__ . '/PlayerCPU.php');
require_once(__DIR__ . '/TotalPointCalculator.php');

$deck = new Deck();
$totalPointCalculator = new TotalPointCalculator();
$player = new Player('あなた');
$cp1 = new PlayerCPU('CP1');
$cp2 = new PlayerCPU('CP2');
$dealer = new Dealer('ディーラー');

echo 'ブラックジャックを始めます。' . PHP_EOL;

$playerCard1 = $player->drawCard($deck);
$playerCard2 = $player->drawCard($deck);

$cp1Card1 = $cp1->drawCard($deck);
$cp1Card2 = $cp1->drawCard($deck);

$cp2Card1 = $cp2->drawCard($deck);
$cp2Card2 = $cp2->drawCard($deck);

$dealerCard1 = $dealer->drawCard($deck);
$dealerCard2 = $dealer->drawCard($deck);


echo $player->name . 'の引いたカードは' . $playerCard1->getSuit() . 'の' . $playerCard1->getRank() . 'です。' . PHP_EOL;
echo $player->name . 'の引いたカードは' . $playerCard2->getSuit() . 'の' . $playerCard2->getRank() . 'です。' . PHP_EOL;

echo $cp1->name . 'の引いたカードは' . $cp1Card1->getSuit() . 'の' . $cp1Card1->getRank() . 'です。' . PHP_EOL;
echo $cp1->name . 'の引いたカードは' . $cp1Card2->getSuit() . 'の' . $cp1Card2->getRank() . 'です。' . PHP_EOL;

echo $cp2->name . 'の引いたカードは' . $cp2Card1->getSuit() . 'の' . $cp2Card1->getRank() . 'です。' . PHP_EOL;
echo $cp2->name . 'の引いたカードは' . $cp2Card2->getSuit() . 'の' . $cp2Card2->getRank() . 'です。' . PHP_EOL;

echo $dealer->name . 'の引いたカードは' . $dealerCard1->getSuit() . 'の' . $dealerCard1->getRank() . 'です。' . PHP_EOL;
echo $dealer->name . 'の引いた2枚目のカードはわかりません。' . PHP_EOL;

$playerCards = [$playerCard1->getRank(), $playerCard2->getRank()];
$cp1Cards = [$cp1Card1->getRank(), $cp1Card2->getRank()];
$cp2Cards = [$cp2Card1->getRank(), $cp2Card2->getRank()];
$dealerCards = [$dealerCard1->getRank(), $dealerCard2->getRank()];

$playerTotalPoint = $totalPointCalculator->calculateTotalPoint($playerCards);
$cp1TotalPoint = $totalPointCalculator->calculateTotalPoint($cp1Cards);
$cp2TotalPoint = $totalPointCalculator->calculateTotalPoint($cp2Cards);
$dealerTotalPoint = $totalPointCalculator->calculateTotalPoint($dealerCards);

echo 'あなたの現在の得点は' . $playerTotalPoint . 'です。カードを引きますか？（Y/N）' . PHP_EOL;

$judge =  trim(fgets(STDIN));

if ($judge == "Y") {
  $playerTotalPoint = $player->action($playerCards, $playerTotalPoint);
} elseif ($judge == "N") {
  $cp1TotalPoint = $cp1->action($cp1Cards, $cp1TotalPoint);
  $cp2TotalPoint = $cp2->action($cp2Cards, $cp2TotalPoint);
  echo 'ディーラーの引いた2枚目のカードは' . $dealerCard2->getSuit() . 'の' . $dealerCard2->getRank() . 'でした。' . PHP_EOL;
  $dealerTotalPoint = $dealer->action($dealerCards, $dealerTotalPoint);
} else {
  while (true) {
    echo 'YかNで入力してください。' . PHP_EOL;
    echo 'あなたの現在の得点は' . $playerTotalPoint . 'です。カードを引きますか？（Y/N）' . PHP_EOL;
    $judge = trim(fgets(STDIN));
    if ($judge == "Y") {
      $playerTotalPoint = $player->action($playerCards, $playerTotalPoint);
      break;
    } elseif ($judge == "N") {
      $cp1TotalPoint = $cp1->action($cp1Cards, $cp1TotalPoint);
      $cp2TotalPoint = $cp2->action($cp2Cards, $cp2TotalPoint);
      echo 'ディーラーの引いた2枚目のカードは' . $dealerCard2->getSuit() . 'の' . $dealerCard2->getRank() . 'でした。' . PHP_EOL;
      $dealerTotalPoint = $dealer->action($dealerCards, $dealerTotalPoint);
      break;
    } else {
      continue;
    }
  }
}

echo 'ディーラーの引いた2枚目のカードは' . $dealerCard2->getSuit() . 'の' . $dealerCard2->getRank() . 'でした。' . PHP_EOL;
$dealerTotalPoint = $dealer->action($dealerCards, $dealerTotalPoint);

echo 'あなたの得点は' . $playerTotalPoint . 'です。' . PHP_EOL;
echo 'CP1の得点は' . $cp1TotalPoint . 'です。' . PHP_EOL;
echo 'CP2の得点は' . $cp2TotalPoint . 'です。' . PHP_EOL;
echo 'ディーラーの得点は' . $dealerTotalPoint . 'です。' . PHP_EOL;

$players = [
  [$player, $playerTotalPoint],
  [$cp1, $cp1TotalPoint],
  [$cp2, $cp2TotalPoint],
];

foreach ($players as $player) {
  echo '------------------------' . PHP_EOL;
  $winner = getWinner($player[0], $dealer, $player[1], $dealerTotalPoint);
  showWinner($winner);
}

echo 'ブラックジャックを終了します。' . PHP_EOL;


function getWinner(User $player, Dealer $dealer, int $playerTotalPoint, int $dealerTotalPoint): string
{
  $playerName = $player->getName();
  $dealerName = $dealer->getName();

  if ($playerTotalPoint > 21) {
    return $dealerName;
  } elseif ($playerTotalPoint > $dealerTotalPoint) {
    return $playerName;
  } elseif ($dealerTotalPoint > 21) {
    return $playerName;
  } elseif ($playerTotalPoint === $dealerTotalPoint) {
    return '引き分け';
  } elseif ($playerTotalPoint < $dealerTotalPoint) {
    return $dealerName;
  }
}

function showWinner(string $winner): void
{
  if ($winner == '引き分け') {
    echo '引き分けです。' . PHP_EOL;
  } else {
    echo $winner . 'の勝利です!' . PHP_EOL;
  }
}
