<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;
use App\Cards\Card;
use App\Cards\Suit;
use App\Cards\CardHand;

class BankTest extends TestCase
{
    public function testmakeDecisionUnder17()
    {
        $bank = new Bank();
        $card = new Card(Suit::Hearts, 5);
        $bank->addPlayerHand($card);

        $res = $bank->makeDecision();
        $exp = true;

        $this->assertEquals($res, $exp);
    }

    public function testmakeDecisionOver17()
    {
        $bank = new Bank();
        $card1 = new Card(Suit::Hearts, 5);
        $card2 = new Card(Suit::Hearts, 13);
        $bank->addPlayerHand($card1);
        $bank->addPlayerHand($card2);

        $res = $bank->makeDecision();
        $exp = false;

        $this->assertEquals($res, $exp);
    }
}
