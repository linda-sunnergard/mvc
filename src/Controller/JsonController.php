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

class JsonController extends AbstractController
{
    #[Route("/api", name: "api")]
    public function home(): Response
    {
        return $this->render('api/home.html.twig');
    }

    #[Route("/api/quote", name: "api_quote")]
    public function rand_quote(): Response
    {
        $quotes = array(
            'This too shall pass',
            'The most important step to take is the next',
            'An empty vessel makes much noise'
        );
        $key = array_rand($quotes);

        $date = date('Y-m-d');

        $time_answer = date('H:i:s');

        $data = [
            'random_quote' => $quotes[$key],
            'quote_generated' => $time_answer,
            'today' => $date
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck", name: "api_deck_sort", methods:"GET")]
    public function api_deck_sort(): Response
    {
        $deck = new DeckOfCards();

        $graphicCards = [];

        foreach ($deck->sort_deck() as $card) {
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

    #[Route("/api/deck/shuffle", name: "api_deck_shuffle")]
    public function api_deck_shuffle(
        SessionInterface $session
    ): Response {
        $deck = new DeckOfCards();
        $session->set("deck", $deck);

        $graphicCardsShuffled = [];

        foreach ($deck->shuffle_deck() as $card) {
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

    #[Route("/api/deck/draw", name: "api_deck_draw")]
    public function draw(
        SessionInterface $session
    ): Response {
        $hand = $session->get("hand", new CardHand());
        $deck = $session->get("deck", new DeckOfCards());

        if ($deck->count_deck() == 0) {
            throw new \Exception("No cards left!");
        }

        $card = $deck->draw_card();
        $hand->add($card);

        $graphicCard = $card->toString();
        $graphicDeck = [];

        foreach ($deck->get_deck() as $current_card) {
            $graphicDeck[] = $current_card->toString();
        }

        $numCardsLeft = $deck->count_deck();

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

    #[Route("/api/deck/draw/{num<\d+>}", name: "api_deck_draw_many")]
    public function draw_post(
        int $num,
        Request $request,
        SessionInterface $session
    ): Response {
        $hand = $session->get("hand", new CardHand());
        $deck = $session->get("deck", new DeckOfCards());

        if ($deck->count_deck() < $num) {
            throw new \Exception("Not enough cards left!");
        }

        $new_cards = $deck->draw_cards($num);
        $graphicCards = [];

        foreach ($new_cards as $current_card) {
            $graphicCards[] = $current_card->toString();
            $hand->add($current_card);
        }

        $graphicDeck = [];
        foreach ($deck->get_deck() as $card) {
            $graphicDeck[] = $card->toString();
        }

        $session->set("hand", $hand);
        $session->set("deck", $deck);

        $numCardsLeft = $deck->count_deck();

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
}
