<?php

namespace App\Cards;

use App\Cards\Card;

class CardHand
{
    protected array $hand = [];

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

    public function getStringJson(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->toString();
        }
        return $values;
    }

    public function getHand(): array
    {
        return $this->hand;
    }
}
