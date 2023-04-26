<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

class CardHandTest extends TestCase
{
    public function testAddNoArgument()
    {
        $hand = new CardHand();

        $this->expectExceptionMessage("You need to pick a card to add to your hand.");
        $hand->add();

    }

    public function testAdd()
    {
        $card = new Card(Suit::Hearts, 5);
        $hand = new CardHand();

        $hand->add($card);

        $this->assertCount(1, $hand->getHand());
        $this->assertContains($card, $hand->getHand());
    }

    public function testGetNumberCards()
    {
        $card1 = new Card(Suit::Hearts, 4);
        $card2 = new Card(Suit::Hearts, 5);
        $card3 = new Card(Suit::Hearts, 6);

        $hand = new CardHand();

        $hand->add($card1);
        $hand->add($card2);
        $hand->add($card3);

        $res = $hand->getNumberCards();
        $exp = 3;

        $this->assertEquals($res, $exp);
    }

    public function testGetString()
    {
        $card1 = new CardGraphic(Suit::Hearts, 4);
        $card2 = new CardGraphic(Suit::Hearts, 5);
        $card3 = new CardGraphic(Suit::Hearts, 6);

        $hand = new CardHand();

        $hand->add($card1);
        $hand->add($card2);
        $hand->add($card3);

        $res = $hand->getString();

        $card1Graphic = '[♥︎4]';
        $card2Graphic = '[♥︎5]';
        $card3Graphic = '[♥︎6]';

        $this->assertCount(3, $res);
        $this->assertContains($card1Graphic, $res);
        $this->assertContains($card2Graphic, $res);
        $this->assertContains($card3Graphic, $res);
    }

    public function testGetStringJson()
    {
        $card1 = new CardGraphic(Suit::Hearts, 4);
        $card2 = new CardGraphic(Suit::Hearts, 5);
        $card3 = new CardGraphic(Suit::Hearts, 6);

        $hand = new CardHand();

        $hand->add($card1);
        $hand->add($card2);
        $hand->add($card3);

        $res = $hand->getStringJson();

        $card1Graphic = '[Hearts4]';
        $card2Graphic = '[Hearts5]';
        $card3Graphic = '[Hearts6]';

        $this->assertCount(3, $res);
        $this->assertContains($card1Graphic, $res);
        $this->assertContains($card2Graphic, $res);
        $this->assertContains($card3Graphic, $res);
    }

    public function testGetHand()
    {
        $card1 = new Card(Suit::Hearts, 4);
        $card2 = new Card(Suit::Hearts, 5);
        $card3 = new Card(Suit::Hearts, 6);

        $hand = new CardHand();

        $hand->add($card1);
        $hand->add($card2);
        $hand->add($card3);

        $res = $hand->getHand();

        $this->assertCount(3, $res);
        $this->assertIsArray($res);
    }
}
