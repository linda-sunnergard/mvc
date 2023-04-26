<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;
use App\Cards\DeckOfCards;
use App\Cards\GraphicCard;
use App\Cards\Card;
use App\Cards\Suit;

class GameTestWinner extends TestCase
{
    public function testplayerWinsBankMorePoints()
    {
        $game = new Game();
        $bank = $game->getPlayer("bank");

        $card = new Card(Suit::Hearts, 5);
        $bank->addPlayerHand($card);

        $res = $game->playerWins();
        $exp = false;

        $this->assertEquals($res, $exp);
    }

    public function testplayerWinsBankNoPoints()
    {
        $game = new Game();

        $res = $game->playerWins();
        $exp = false;

        $this->assertEquals($res, $exp);
    }

    public function testplayerWinsBankOver21()
    {
        $game = new Game();
        $bank = $game->getPlayer("bank");

        $card1 = new Card(Suit::Hearts, 13);
        $card2 = new Card(Suit::Hearts, 12);
        $bank->addPlayerHand($card1);
        $bank->addPlayerHand($card2);

        $res = $game->playerWins();
        $exp = true;

        $this->assertEquals($res, $exp);
    }

    public function testplayerWins()
    {
        $game = new Game();
        $bank = $game->getPlayer("bank");
        $player = $game->getPlayer("player");

        $card1 = new Card(Suit::Hearts, 5);
        $card2 = new Card(Suit::Hearts, 6);
        $bank->addPlayerHand($card1);
        $player->addPlayerHand($card2);

        $res = $game->playerWins();
        $exp = true;

        $this->assertEquals($res, $exp);
    }
}
