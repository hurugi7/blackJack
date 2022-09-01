<?php

require_once(__DIR__ . '/Deck.php');
require_once(__DIR__ . '/TotalPointCalculator.php');

abstract class User
{
  public Deck $deck;
  public TotalPointCalculator $totalPointCalculator;

  public function __construct(public string $name)
  {
    $this->deck = new Deck();
    $this->totalPointCalculator = new TotalPointCalculator();
  }

  abstract function action(array $cards, int $totalPoint);

  public function drawCard(Deck $deck) {
    shuffle($deck->cards);
    $card = array_slice($deck->cards, 0, 1)[0];
    array_splice($deck->cards, 0, 1);
    return $card;
  }

  public function getName(): string
  {
    return $this->name;
  }
}
