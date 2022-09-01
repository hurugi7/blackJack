<?php

class Card
{
  public function __construct(private string $suit, private $rank)
  {
  }

  public function getSuit(): string
  {
    return $this->suit;
  }

  public function getRank()
  {
    return $this->rank;
  }

}
