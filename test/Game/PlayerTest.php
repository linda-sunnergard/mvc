<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;
use App\Cards\Card;
use App\Cards\CardGraphic;
use App\Cards\Suit;
use App\Cards\CardHand;

class PlayerTest extends TestCase
{
    public function testaddPlayerHandNoArgument()
    {
        $player = new Player();

        $this->expectExceptionMessage("Failed to add card to the player's hand.");
        $player->addPlayerHand();
    }

    public function testaddPlayerHand()
    {
        $player = new Player();
        $card = new Card(Suit::Hearts, 5);

        $player->addPlayerHand($card);

        $hand = $player->getCardHandArray();

        $this->assertIsArray($hand);
        $this->assertCount(1, $hand);
        $this->assertEquals($card, $hand[0]);
    }

    public function testcalcPoints()
    {
        $player = new Player();
        $card = new Card(Suit::Hearts, 5);
        $player->addPlayerHand($card);

        $res = $player->calcPoints();
        $exp = 5;

        $this->assertEquals($res, $exp);
    }

    public function testcalcPointsHighAce()
    {
        $player = new Player();
        $card = new Card(Suit::Hearts, 1);
        $player->addPlayerHand($card);

        $res = $player->calcPoints();
        $exp = 14;

        $this->assertEquals($res, $exp);
    }

    public function testcalcPointsLowAce()
    {
        $player = new Player();
        $card1 = new Card(Suit::Hearts, 1);
        $card2 = new Card(Suit::Hearts, 13);
        $card3 = new Card(Suit::Hearts, 12);

        $player->addPlayerHand($card1);
        $player->addPlayerHand($card2);
        $player->addPlayerHand($card3);

        $res = $player->calcPoints();
        $exp = 26;

        $this->assertEquals($res, $exp);
    }

    public function testgetCardHandArray()
    {
        $player = new Player();
        $card = new Card(Suit::Hearts, 5);
        $player->addPlayerHand($card);

        $playerHand = $player->getCardHandArray();

        $this->assertIsArray($playerHand);
        $this->assertCount(1, $playerHand);
        $this->assertEquals($card, $playerHand[0]);
    }

    public function testgetHand()
    {
        $player = new Player();
        $card = new CardGraphic(Suit::Hearts, 5);
        $player->addPlayerHand($card);

        $res = $player->getHand();
        $exp = '[♥︎5]';

        $this->assertIsArray($res);
        $this->assertCount(1, $res);
        $this->assertEquals($exp, $res[0]);
    }

    public function testgetHandJson()
    {
        $player = new Player();
        $card = new CardGraphic(Suit::Hearts, 5);
        $player->addPlayerHand($card);

        $res = $player->getHandJson();
        $exp = '[Hearts5]';

        $this->assertIsArray($res);
        $this->assertCount(1, $res);
        $this->assertEquals($exp, $res[0]);
    }
}
