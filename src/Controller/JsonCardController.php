<?php

namespace App\Controller;

use App\Cards\Card;
use App\Cards\CardGraphic;
use App\Cards\CardHand;
use App\Cards\DeckOfCards;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class JsonCardController extends AbstractController
{
    #[Route("/api/deck", name: "apiDeckSort", methods:"GET")]
    public function apiDeckSort(): Response
    {
        $deck = new DeckOfCards();

        $graphicCards = [];

        foreach ($deck->sortDeck() as $card) {
            $graphicCards[] = $card->toString();
        }

        $data = [
            'deck_sorted' => $graphicCards
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name: "apiDeckShuffle")]
    public function apiDeckShuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("deck", $deck);

        $graphicCardsShuffled = [];

        foreach ($deck->shuffleDeck() as $card) {
            $graphicCardsShuffled[] = $card->toString();
        }

        $data = [
            "deck_shuffled" => $graphicCardsShuffled
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name: "apiDeckDraw")]
    public function apiDeckDraw(
        SessionInterface $session
    ): Response {
        $hand = $session->get("hand", new CardHand());
        $deck = $session->get("deck", new DeckOfCards());

        if ($deck->countDeck() == 0) {
            throw new Exception("No cards left!");
        }

        $card = $deck->drawCard();
        $hand->add($card);

        $graphicCard = $card->toString();
        $graphicDeck = [];

        foreach ($deck->getDeck() as $currentCard) {
            $graphicDeck[] = $currentCard->toString();
        }

        $numCardsLeft = $deck->countDeck();

        $data = [
            "card" => $graphicCard,
            "numCardsLeft" => $numCardsLeft,
            "deck" => $graphicDeck
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/{num<\d+>}", name: "apiDeckDrawMany")]
    public function apiDeckDrawMany(
        int $num,
        SessionInterface $session
    ): Response {
        $hand = $session->get("hand", new CardHand());
        $deck = $session->get("deck", new DeckOfCards());

        if ($deck->countDeck() < $num) {
            throw new Exception("Not enough cards left!");
        }

        $newCards = $deck->drawCards($num);
        $graphicCards = [];

        foreach ($newCards as $currentCard) {
            $graphicCards[] = $currentCard->toString();
            $hand->add($currentCard);
        }

        $graphicDeck = [];
        foreach ($deck->getDeck() as $card) {
            $graphicDeck[] = $card->toString();
        }

        $session->set("hand", $hand);
        $session->set("deck", $deck);

        $numCardsLeft = $deck->countDeck();

        $data = [
            "card(s)" => $graphicCards,
            "numCardsLeft" => $numCardsLeft,
            "deck" => $graphicDeck
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/game", name: "apiGame")]
    public function apiGame(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");

        $player = $game->getPlayer("player");
        $playerHand = $game->getPlayerHandJson($player);
        $playerPoints = $player->calcPoints();

        $bank = $game->getPlayer("bank");
        $bankHand = $game->getPlayerHandJson($bank);
        $bankPoints = $bank->calcPoints();

        $data = [
            "playerHand" => $playerHand,
            "playerPoints" => $playerPoints,
            "bankHand" => $bankHand,
            "bankPoints" => $bankPoints
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
