<?php

namespace App\Controller;

use App\Cards\Card;
use App\Cards\CardGraphic;
use App\Cards\CardHand;
use App\Cards\DeckOfCards;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

class JsonController extends AbstractController
{
    #[Route("/api", name: "api")]
    public function home(): Response
    {
        return $this->render('api/home.html.twig');
    }

    #[Route("/api/quote", name: "apiQuote")]
    public function randQuote(): Response
    {
        $quotes = array(
            'This too shall pass',
            'The most important step to take is the next',
            'An empty vessel makes much noise'
        );
        $key = array_rand($quotes);

        $date = date('Y-m-d');

        $timeAnswer = date('H:i:s');

        $data = [
            'random_quote' => $quotes[$key],
            'quote_generated' => $timeAnswer,
            'today' => $date
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/library/books", name: "apiLibraryBooks")]
    public function apiLibraryBooks(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $data = [];

        foreach($books as $book) {
            $id = $book->getId();

            $bookData = [];

            $title = $book->getTitle();
            $bookData["title"] = $title;

            $author = $book->getAuthor();
            $bookData["author"] = $author;

            $isbn = $book->getIsbn();
            $bookData["isbn"] = $isbn;

            $image = $book->getImage();
            $bookData["image"] = $image;

            $data["book".$id] = $bookData;
        }

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    
    #[Route("/api/library/book/123", name: "apiLibraryBookPannkaka")]
    public function apiLibraryBookPannkaka(
        BookRepository $bookRepository,
    ): Response {
        $book = $bookRepository
            ->findOneBy(array('isbn' => 123));

        $title = $book->getTitle();
        $author = $book->getAuthor();
        $isbn = $book->getIsbn();
        $image = $book->getImage();

        $data = [
            "title" => $title,
            "author" => $author,
            "isbn" => $isbn,
            "image" => $image
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    
    #[Route("/api/library/book/{isbn}", name: "apiLibraryBookIsbn")]
    public function apiLibraryBookIsbn(
        BookRepository $bookRepository,
        int $isbn
    ): Response {
        $book = $bookRepository
            ->findOneBy(array('isbn' => $isbn));

        $title = $book->getTitle();
        $author = $book->getAuthor();
        $isbn = $book->getIsbn();
        $image = $book->getImage();

        $data = [
            "title" => $title,
            "author" => $author,
            "isbn" => $isbn,
            "image" => $image
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
