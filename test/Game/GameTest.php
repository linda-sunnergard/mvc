<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;
use App\Cards\DeckOfCards;
use App\Cards\GraphicCard;
use App\Cards\Card;
use App\Cards\Suit;

class GameTest extends TestCase
{
    public function testdrawGameCard()
    {
        $game = new Game();
        $player = $game->getPlayer("player");
        $playerHandBefore = $game->getPlayerHand($player);

        $this->assertCount(0, $playerHandBefore);

        $card = $game->drawGameCard();
        $playerHandAfter = $game->getPlayerHand($player);

        $this->assertIsObject($card);
        $this->assertCount(1, $playerHandAfter);
    }

    public function testdrawGameCardBank()
    {
        $game = new Game();
        $bank = $game->getPlayer("bank");
        $bankHandBefore = $game->getPlayerHand($bank);

        $game->drawGameCardBank();

        $bankHandAfter = $game->getPlayerHand($bank);
        $bankPoints = $bank->calcPoints();

        $this->assertCount(0, $bankHandBefore);
        $this->assertGreaterThan(1, count($bankHandAfter));
        $this->assertGreaterThanOrEqual(17, $bankPoints);
        $this->assertLessThanOrEqual(29, $bankPoints);
    }

    public function testgetPlayerHandNoArgument()
    {
        $game = new Game();

        $this->expectExceptionMessage("Please pick a player");
        $game->getPlayerHand();
    }

    public function testgetPlayerHand()
    {
        $game = new Game();
        $bank = $game->getPlayer("bank");
        $player = $game->getPlayer("player");

        $res1 = $game->getPlayerHand($bank);
        $res2 = $game->getPlayerHand($player);

        $this->assertIsArray($res1);
        $this->assertIsArray($res2);
    }

    public function testgetPlayerHandJsonNoArg()
    {
        $game = new Game();

        $this->expectExceptionMessage("Please pick a player");
        $game->getPlayerHandJson();
    }

    public function testgetPlayerHandJson()
    {
        $game = new Game();

        $game = new Game();
        $bank = $game->getPlayer("bank");
        $player = $game->getPlayer("player");

        $res1 = $game->getPlayerHandJson($bank);
        $res2 = $game->getPlayerHandJson($player);

        $this->assertIsArray($res1);
        $this->assertIsArray($res2);
    }

    public function testgetPlayerNoArg()
    {
        $game = new Game();

        $this->expectExceptionMessage("Please pick a player");
        $game->getPlayer();
    }

    public function testgetPlayer()
    {
        $game = new Game();

        $game = new Game();
        $res1 = $game->getPlayer("bank");
        $res2 = $game->getPlayer("player");

        $this->assertIsObject($res1);
        $this->assertIsObject($res2);

    }

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
