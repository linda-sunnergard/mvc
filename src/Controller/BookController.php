<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class BookController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }


    #[Route("/library/create", name: "library_create", methods: ['GET'])]
    public function libraryCreate(): Response
    {

        return $this->render('library/library_create.html.twig');
    }

    #[Route("/library/create", name: "library_create_post", methods: ['POST'])]
    public function libraryCreatePost(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();

        $isbn = $request->request->get('isbn');
        $title = $request->request->get('title');
        $author = $request->request->get('author');

        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);
        $book->setImage('default.jpg');

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_show_all');
    }

    #[Route('/library/show', name: 'library_show_all')]
    public function libraryShowAll(
        BookRepository $bookRepository
    ): Response {
        $books = $bookRepository
            ->findAll();

        $data = [
            "library" => $books
        ];

        return $this->render('library/library_show_all.html.twig', $data);
    }

    #[Route('/library/show/{id}', name: 'library_show_by_id')]
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        $data = [
            "book" => $book
        ];

        return $this->render('library/library_show_one.html.twig', $data);
    }

    #[Route('/library/delete/{id}', name: 'library_delete_by_id', methods: ['GET'])]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $data = [
            "book" => $book
        ];

        return $this->render('library/library_delete.html.twig', $data);
    }

    #[Route('/library/delete/{id}', name: 'library_delete_by_id_post', methods: ['POST'])]
    public function deleteBookByIdPost(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_show_all');
    }

    #[Route('/library/update/{id}', name: 'library_update_by_id', methods: ['GET'])]
    public function updateBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $data = [
            "book" => $book
        ];

        return $this->render('library/library_update.html.twig', $data);
    }

    #[Route('/library/update/{id}', name: 'library_update_by_id_post', methods: ['POST'])]
    public function updateBookByIdPost(
        ManagerRegistry $doctrine,
        Request $request,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $title = $request->request->get('title');
        $book->setTitle($title);
        $entityManager->flush();

        $author = $request->request->get('author');
        $book->setAuthor($author);
        $entityManager->flush();

        $isbn = $request->request->get('isbn');
        $book->setIsbn($isbn);
        $entityManager->flush();

        return $this->redirectToRoute('library_show_all');
    }

    #[Route('/library/reset', name: 'library_reset')]
    public function libraryReset(
        ManagerRegistry $doctrine,
        BookRepository $bookRepository
    ): Response {
        $entityManager = $doctrine->getManager();

        $books = $bookRepository
        ->findAll();

        foreach ($books as $book) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        $book1 = new Book();
        $book1->setTitle('Pannkakstårtan');
        $book1->setAuthor('Sven Nordqvist');
        $book1->setIsbn(9789172703377);
        $book1->setImage('pannkakstartan.jpg');

        $entityManager->persist($book1);
        $entityManager->flush();

        $book2 = new Book();
        $book2->setTitle('Känner du Pippi Långstrump?');
        $book2->setAuthor('Astrid Lindgren');
        $book2->setIsbn(9789129698442);
        $book2->setImage('pippi.jpg');

        $entityManager->persist($book2);
        $entityManager->flush();

        $book3 = new Book();
        $book3->setTitle('Solägget');
        $book3->setAuthor('Elsa Beskow');
        $book3->setIsbn(9789178031542);
        $book3->setImage('solagget.jpg');

        $entityManager->persist($book3);
        $entityManager->flush();

        $book4 = new Book();
        $book4->setTitle('Testbok');
        $book4->setAuthor('Testperson');
        $book4->setIsbn(1234567890);
        $book4->setImage('default.jpg');

        $entityManager->persist($book4);
        $entityManager->flush();

        return new Response('The database has been reset.');
    }
}
