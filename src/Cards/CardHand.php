<?php

namespace App\Cards;

use App\Cards\Card;

class CardHand
{
    protected $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    public function getHand(): array
    {
        return $this->hand;
    }
}
