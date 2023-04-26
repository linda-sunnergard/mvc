<?php

namespace App\Cards;

use PHPUnit\Framework\TestCase;

class DeckOfCardsTest extends TestCase
{
    public function testSortDeck()
    {
        $deck = new DeckOfCards();
        $deck->sortDeck();

        $cards = $deck->getDeck();

        $card1 = new CardGraphic(Suit::Hearts, 5);
        $card2 = new CardGraphic(Suit::Diamonds, 5);
        $card3 = new CardGraphic(Suit::Spades, 5);
        $card4 = new CardGraphic(Suit::Clubs, 5);

        $this->assertIsArray($cards);
        $this->assertEquals($cards[4], $card1);
        $this->assertEquals($cards[17], $card2);
        $this->assertEquals($cards[30], $card3);
        $this->assertEquals($cards[43], $card4);
    }

    public function testShuffleDeck()
    {
        $deck = new DeckOfCards();
        $deck->shuffleDeck();

        $cards = $deck->getDeck();

        $this->assertIsArray($cards);
    }

    public function testDrawCard()
    {
        $deck = new DeckOfCards();
        $res = $deck->drawCard();

        $this->assertIsObject($res);
    }

    public function testDrawCardsNoArgument()
    {
        $deck = new DeckOfCards();
        $res = $deck->drawCards();

        $this->assertIsArray($res);
        $this->assertCount(1, $res);
    }

    public function testDrawCards()
    {
        $deck = new DeckOfCards();
        $res = $deck->drawCards(2);

        $this->assertIsArray($res);
        $this->assertCount(2, $res);
    }

    public function testremoveCardNoArgument()
    {
        $deck = new DeckOfCards();

        $this->expectExceptionMessage("Failed to remove card from deck.");
        $deck->removeCard();
    }

    public function testremoveCard()
    {
        $deck = new DeckOfCards();
        $deckBeforeRemove = $deck->getDeck();
        $cardIndex = 4;

        $this->assertCount(52, $deckBeforeRemove);
        $this->assertIsArray($deckBeforeRemove);

        $deck->removeCard($cardIndex);

        $deckAfterRemove = $deck->getDeck();

        $this->assertCount(51, $deckAfterRemove);
        $this->assertIsArray($deckAfterRemove);
    }

    public function testgetDeck()
    {
        $deck = new DeckOfCards();
        $deckArray = $deck->getDeck();

        $this->assertIsArray($deckArray);
    }

    public function testCountDeck()
    {
        $deck = new DeckOfCards();

        $res = $deck->countDeck();
        $exp = 52;

        $this->assertEquals($res, $exp);
    }
}
