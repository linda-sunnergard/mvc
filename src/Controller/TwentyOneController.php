<?php

namespace App\Controller;

use App\Cards\Card;
use App\Cards\CardGraphic;
use App\Cards\CardHand;
use App\Cards\DeckOfCards;
use App\Game\Game;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwentyOneController extends AbstractController
{
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('game/home.html.twig');
    }

    #[Route("/game/doc", name: "doc")]
    public function doc(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    #[Route("/game/init", name: "game_init_get", methods: ['GET'])]
    public function gameInit(): Response
    {
        return $this->render('game/init.html.twig');
    }

    #[Route("/game/init", name: "game_init_post", methods: ['POST'])]
    public function gameInitCallback(
        SessionInterface $session
    ): Response {

        $game = new Game();
        $drawResponse = $game->drawGameCard();

        $session->set("game", $game);
        $session->set("current_card", $drawResponse->card->getAsString());
        $session->set("currentPoints", $drawResponse->currentPoints);

        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/play", name: "game_play", methods: ['GET'])]
    public function gamePlay(
        SessionInterface $session
    ): Response {
        $data = [
            "current_card" => $session->get("current_card"),
            "currentPoints" => $session->get("currentPoints")
        ];

        return $this->render('game/play.html.twig', $data);
    }

    #[Route("/game/play/draw", name: "game_draw", methods: ['POST'])]
    public function gameDraw(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");
        $drawResponse = $game->drawGameCard();
        $currentPoints = $drawResponse->currentPoints;

        if ($currentPoints >= 21) {
            return $this->redirectToRoute('game_finish');
        }

        $session->set("game", $game);
        $session->set("current_card", $drawResponse->card->getAsString());
        $session->set("currentPoints", $currentPoints);

        return $this->redirectToRoute('game_play');
    }

    #[Route("/game/play/bank", name: "game_bank", methods: ['POST'])]
    public function gameBank(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");
        $game->drawGameCardBank();

        $session->set("game", $game);

        return $this->redirectToRoute('game_finish');
    }

    #[Route("/game/play/finish", name: "game_finish", methods: ['GET'])]
    public function gameFinish(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");

        $player = $game->getPlayer("player");
        $playerHand = $game->getPlayerHand($player);
        $playerPoints = $player->calcPoints();
        $playerWins = $game->playerWins();

        $bank = $game->getPlayer("bank");
        $bankHand = $game->getPlayerHand($bank);
        $bankPoints = $bank->calcPoints();

        $data = [
            "player_hand" => $playerHand,
            "player_points" => $playerPoints,
            "playerWins" => $playerWins,
            "bank_hand" => $bankHand,
            "bank_points" => $bankPoints
        ];

        return $this->render('game/finish.html.twig', $data);
    }
}
