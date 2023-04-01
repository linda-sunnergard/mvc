<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class meController extends AbstractController
{
    #[Route("/lucky", name: "lucky")]
    public function numluckyber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky.html.twig', $data);
    }

    #[Route("/home", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/excersice", name: "excersice")]
    public function excersice(): Response
    {
        return $this->render('excersice.html.twig');
    }

    #[Route("/api/quote", name: "quote")]
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
}