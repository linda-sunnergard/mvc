<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    //best way to test construct? add throw exception?
    //cant/wont read config?
    //is namespace correct?
    public function testgetValue()
    {
        $card = new CardGraphic(Suit::Hearts, 5);

        $res = $card->getValue();
        $exp = 5;

        $this->assertEquals($res, $exp);
    }

    public function testgetSuit()
    {
        $card = new CardGraphic(Suit::Hearts, 5);

        $res = $card->getSuit();
        $exp = Suit::Hearts;

        $this->assertEquals($res, $exp);
    }
}
