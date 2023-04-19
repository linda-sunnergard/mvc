<?php

namespace App\Cards;

enum Suit
{
    case Hearts;
    case Diamonds;
    case Clubs;
    case Spades;
}

class Card
{
    protected Suit $suit;
    protected int $value;

    public function __construct(Suit $suit, int $value)
    {
        $this->value = $value;
        $this->suit = $suit;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getSuit(): Suit
    {
        return $this->suit;
    }
}
