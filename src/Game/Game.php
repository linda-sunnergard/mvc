<?php

namespace App\Game;

use App\Game\Player;
use App\Game\Bank;
use App\Cards\DeckOfCards;
use App\Game\DrawResponse;

class Game
{
    protected $player;
    protected $bank;
    protected $deck;

    public function __construct()
    {
        $this->player = new Player();
        $this->bank = new Bank();
        $this->deck = new DeckOfCards();
    }

    public function drawGameCard(): DrawResponse
    {
        $card = $this->deck->drawCard();
        $this->player->addPlayerHand($card);
        $currentPoints = $this->player->calcPoints();

        $drawResponse = new DrawResponse($card, $currentPoints);

        return $drawResponse;
    }

    public function drawGameCardBank(): void
    {
        $card = $this->deck->drawCard();
        $this->bank->addPlayerHand($card);

        $drawAgain = $this->bank->makeDecision();

        if ($drawAgain) {
            $this->drawGameCardBank();
        }
    }

    public function playerWins(): bool
    {
        $playerPoints = $this->player->calcPoints();
        $bankPoints = $this->bank->calcPoints();
        $playerWins = false;

        if ($bankPoints >= $playerPoints or $bankPoints == 0) {
            if ($bankPoints <= 21) {
                return $playerWins;
            }
        }

        $playerWins = true;

        return $playerWins;
    }

    public function getPlayerHand(Player | Bank $player): array
    {
        $hand = $player->getHand();

        return $hand;
    }

    public function getPlayerHandJson(Player | Bank $player): array
    {
        $hand = $player->getHandJson();

        return $hand;
    }

    public function getPlayer(string $player): Player | Bank
    {
        if ($player == "player") {
            return $this->player;
        } elseif ($player == "bank") {
            return $this->bank;
        }
    }
}
