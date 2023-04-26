<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

class CardGraphicTest extends TestCase
{
    public function testgetAsString()
    {
        $card = new CardGraphic(Suit::Hearts, 5);

        $res = $card->getAsString();
        $exp = '[♥︎5]';

        $this->assertEquals($res, $exp);
    }

    public function testtoString()
    {
        $card = new CardGraphic(Suit::Hearts, 5);

        $res = $card->toString();
        $exp = '[Hearts5]';

        $this->assertEquals($res, $exp);
    }
}
