<?php

namespace App\Cards;

class CardGraphic extends Card
{
    /**
     * @param array<string, suits> $suits
     */
    private array $suits = [
        "Spades"=>'♠',
        "Hearts"=>'♥︎',
        "Diamonds"=>'♦︎',
        "Clubs"=>'♣︎'
    ];

    private array $values = [
      1 => "A",
      2 => "2",
      3 => "3",
      4 => "4",
      5 => "5",
      6 => "6",
      7 => "7",
      8 => "8",
      9 => "9",
      10 => "10",
      11 => "Kn",
      12 => "D",
      13 => "K"
    ];

    public function __construct(Suit $suit, int $value)
    {
        parent::__construct($suit, $value);
    }

    public function getAsString(): string
    {

        return '[' . $this->suits[$this->suit->name] . $this->values[$this->value] . ']';
    }

    public function toString(): string
    {
        return '[' . $this->suit->name . $this->values[$this->value] . ']';
    }
}
