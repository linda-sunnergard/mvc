<?php

namespace App\Cards;

use App\Cards\Suit;
use App\Cards\Card;
use App\Cards\CardHand;
use Exception;

class DeckOfCards
{
    private $deck = array();

    public function __construct()
    {
        for ($i = 1; $i <= 13; $i++) {
            $this->deck[] = new CardGraphic(Suit::Hearts, $i);
            $this->deck[] = new CardGraphic(Suit::Diamonds, $i);
            $this->deck[] = new CardGraphic(Suit::Spades, $i);
            $this->deck[] = new CardGraphic(Suit::Clubs, $i);
        }
    }

    public function sortDeck(): array
    {
        $hearts = array();
        $diamonds = array();
        $spades = array();
        $clubs = array();
        foreach ($this->deck as $card) {
            switch ($card->getSuit()) {
                case Suit::Hearts:
                    $hearts[$card->getValue()] = $card;
                    break;
                case Suit::Diamonds:
                    $diamonds[$card->getValue()] = $card;
                    break;
                case Suit::Spades:
                    $spades[$card->getValue()] = $card;
                    break;
                case Suit::Clubs:
                    $clubs[$card->getValue()] = $card;
                    break;
            }
        }
        $this->deck = array_merge($hearts, $diamonds, $spades, $clubs);
        return $this->deck;
    }

    public function shuffleDeck(): array
    {
        shuffle($this->deck);

        return $this->deck;
    }

    public function drawCard(): CardGraphic
    {
        $cardIndex = array_rand($this->deck);

        $cardObject = $this->deck[$cardIndex];
        $this->removeCard($cardIndex);

        return $cardObject;
    }

    public function drawCards(int $numb = null): array
    {
        if($numb <= 1 or $numb === null) {
            return [$this->drawCard()];
        }

        $cardIndexes = array_rand($this->deck, $numb);
        $cards = [];

        foreach ($cardIndexes as $index) {
            $cards[] = $this->deck[$index];
            $this->removeCard($index);
        }

        return $cards;
    }

    public function removeCard(int $card = null): void
    {
        if (is_null($card)) {
            throw new Exception("Failed to remove card from deck.");
        }

        unset($this->deck[$card]);
    }

    public function getDeck(): array
    {
        return array_values($this->deck);
    }

    public function countDeck(): int
    {
        return count($this->deck);
    }
}
