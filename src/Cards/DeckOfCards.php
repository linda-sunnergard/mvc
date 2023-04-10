<?php

namespace App\Cards;

use App\Cards\Suit;
use App\Cards\Card;
use App\Cards\CardHand;

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

    public function sort_deck(): array
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

    public function shuffle_deck(): array
    {
        shuffle($this->deck);

        return $this->deck;
    }

    public function draw_card(): Card
    {
        $card_index = array_rand($this->deck);

        $card_object = $this->deck[$card_index];
        $this->remove_card($card_index);

        return $card_object;
    }

    public function draw_cards(int $numb): array
    {
        if($numb <= 1) {
            return [$this->draw_card()];
        }

        $card_indexes = array_rand($this->deck, $numb);
        $cards = [];


        foreach ($card_indexes as $index) {
            $cards[] = $this->deck[$index];
            $this->remove_card($index);
        }


        return $cards;
    }

    public function remove_card(int $card): void
    {
        unset($this->deck[$card]);
    }

    public function get_deck(): array
    {
        return array_values($this->deck);
    }

    public function count_deck(): int
    {
        return count($this->deck);
    }
}
