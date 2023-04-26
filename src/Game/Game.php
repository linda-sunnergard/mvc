<?php

/**
* @author Linda
* This is a Game class that contains a Player class,
* a Bank class (inherits from Player) and a DeckOfCards class.
* The Game class keeps track of the overall game structure, and
* who the winner is when the game is over.
*/

namespace App\Game;

use App\Game\Player;
use App\Game\Bank;
use App\Cards\DeckOfCards;
use App\Game\DrawResponse;
use Exception;

class Game
{
    /**
    * @var Object
    */
    protected $player;
    /**
    * @var Object
    */
    protected $bank;
    /**
    * @var Object
    */
    protected $deck;

    /**
    * Create a new Game
    */
    public function __construct()
    {
        $this->player = new Player();
        $this->bank = new Bank();
        $this->deck = new DeckOfCards();
    }

    /**
    * Draw a card for the player.
    * @return DrawResponse    Contains a object CardGraphic and int $currentPoints
    */
    public function drawGameCard(): DrawResponse
    {
        $card = $this->deck->drawCard();
        $this->player->addPlayerHand($card);
        $currentPoints = $this->player->calcPoints();

        $drawResponse = new DrawResponse($card, $currentPoints);

        return $drawResponse;
    }

    /**
    * Draw a card for the bank.
    */
    public function drawGameCardBank(): void
    {
        $card = $this->deck->drawCard();
        $this->bank->addPlayerHand($card);

        $drawAgain = $this->bank->makeDecision();

        if ($drawAgain) {
            $this->drawGameCardBank();
        }
    }

    /**
    * Check if the player won the game.
    *
    * @return bool $playerWins      True if player wins, false if bank wins
    */
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

    /**
    * Get the player/bank's hand. Contains the graphic
    * representations of the cards.
    *
    * @param Player|Bank $player      The player/bank whose hand is required
    * @throws Exception                         If no argument is sent in, the user is prompted to do so
    * @return array $hand                       Return array of strings with graphic cards
    */
    public function getPlayerHand(Player | Bank $player = null): array
    {
        if ($player == null) {
            throw new Exception("Please pick a player.");
        }

        $hand = $player->getHand();

        return $hand;
    }

    /**
    * Get the player/bank's hand. Contains the graphic
    * representations of the cards adjusted for Json output.
    *
    * @param Player|Bank $player      The player/bank whose hand is required
    * @throws Exception                         If no argument is sent in, the user is prompted to do so
    * @return array $hand                       Returns array of strings with graphic cards
    */
    public function getPlayerHandJson(Player | Bank $player = null): array
    {
        if ($player == null) {
            throw new Exception("Please pick a player.");
        }

        $hand = $player->getHandJson();

        return $hand;
    }

    /**
    * Get access to either the player or bank.
    *
    * @param string $player             Should be either "bank" or "player"
    * @throws Exception                 If no argument is sent in, the user is prompted to do so
    * @return Player|Bank     Returns the Player or Bank object reuired
    */
    public function getPlayer(string $player = null): Player | Bank
    {
        if ($player == null) {
            throw new Exception("Please pick a player.");
        }

        if ($player == "player") {
            return $this->player;
        } elseif ($player == "bank") {
            return $this->bank;
        }
    }
}
