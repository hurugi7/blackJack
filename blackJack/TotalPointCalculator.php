<?php

class TotalPointCalculator
{
  public function calculateTotalPoint(array $cards): int
  {
    if (in_array('A', $cards)) {
      $aceTimes = array_count_values($cards)['A'];
      $cards = array_diff($cards, ['A']);
      for ($i = 1; $i <= $aceTimes; $i++) {
        $cards[] = 'A';
      }
    }

    $total = 0;
    foreach ($cards as $card) {
      switch ($card) {
        case 10:
        case 'J':
        case 'Q':
        case 'K':
          $total += 10;
          break;

        case 'A':
          if ($total >= 11) {
            $total += 1;
          } else {
            $total += 11;
          }
          break;

        default:
          $total += (int) $card;
      }
    }
    return $total;
  }
}
