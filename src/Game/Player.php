<?php

namespace App\Game;

use App\Cards\CardHand;
use App\Cards\Card;
use App\Cards\DeckOfCards;
use Exception;

class Player
{
    protected $hand;

    public function __construct()
    {
        $this->hand = new CardHand();
    }

    public function addPlayerHand(Card $card = null): void
    {
        if ($card == null) {
            throw new Exception("Failed to add card to the player's hand.");
        }

        $this->hand->add($card);
    }

    public function calcPoints(): int
    {
        $pointsLowAce = 0;
        $pointsHighAce = 0;

        foreach ($this->hand->getHand() as $card) {
            $value = $card->getValue();
            if ($value == 1) {
                $pointsLowAce += $value;
                $pointsHighAce += 14;
            } elseif ($value !== 1) {
                $pointsLowAce += $value;
                $pointsHighAce += $value;
            }
        }
        $bestPoints = $this->lowOrHighAce($pointsLowAce, $pointsHighAce);

        return $bestPoints;
    }

    public function lowOrHighAce(int $lowPoints, int $highPoints)
    {
        if ($highPoints >= 21) {
            return $lowPoints;
        }

        return $highPoints;
    }

    public function getCardHandArray(): array
    {
        return $this->hand->getHand();
    }

    public function getHand(): array
    {
        return $this->hand->getString();
    }

    public function getHandJson(): array
    {
        return $this->hand->getStringJson();
    }
}
