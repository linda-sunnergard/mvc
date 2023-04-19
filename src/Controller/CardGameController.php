<?php

namespace App\Controller;

use App\Cards\Card;
use App\Cards\CardGraphic;
use App\Cards\CardHand;
use App\Cards\DeckOfCards;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class CardGameController extends AbstractController
{
    #[Route("/card", name: "card")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function sort(): Response
    {
        $deck = new DeckOfCards();

        $graphicCards = [];

        foreach ($deck->sortDeck() as $card) {
            $graphicCards[] = $card->getAsString();
        }

        $data = [
            "deck_sorted" => $graphicCards
        ];

        return $this->render('card/card_deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("deck", $deck);

        $graphicCardsShuffled = [];

        foreach ($deck->shuffleDeck() as $card) {
            $graphicCardsShuffled[] = $card->getAsString();
        }

        $data = [
            "deck_shuffled" => $graphicCardsShuffled
        ];
        return $this->render('card/card_deck_shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_deck_draw", methods: ['GET'])]
    public function draw(
        SessionInterface $session
    ): Response {
        $hand = $session->get("hand", new CardHand());
        $deck = $session->get("deck");

        if ($deck->countDeck() == 0) {
            throw new Exception("No cards left!");
        }

        $card = $deck->drawCard();
        $hand->add($card);

        $graphicCard = $card->getAsString();
        $graphicDeck = [];

        foreach ($deck->getDeck() as $currentCard) {
            $graphicDeck[] = $currentCard->getAsString();
        }

        $data = [
            "card" => $graphicCard,
            "deck" => $graphicDeck
        ];
        return $this->render('card/card_deck_draw.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_deck_draw_post", methods: ['POST'])]
    public function drawPost(
        Request $request,
        SessionInterface $session
    ): Response {
        $numCards = $request->request->get('num_cards');
        $hand = $session->get("hand", new CardHand());
        $deck = $session->get("deck");

        if ($deck->countDeck() < $numCards) {
            throw new Exception("Not enough cards left!");
        }

        $cards = $deck->drawCards($numCards);
        $graphicCards = [];

        foreach ($cards as $card) {
            $hand->add($card);
            $graphicCards[] = $card->getAsString();
        }

        $graphicDeck = [];
        foreach ($deck->getDeck() as $card) {
            $graphicDeck[] = $card->getAsString();
        }

        $session->set("hand", $hand);
        $session->set("deck", $deck);

        $data = [
            "card" => $graphicCards,
            "deck" => $graphicDeck
        ];
        return $this->render('card/card_deck_draw.html.twig', $data);
    }
}
