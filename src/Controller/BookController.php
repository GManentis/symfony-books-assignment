<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/library/{library}/book')]
class BookController extends AbstractController
{
    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(Request $request, BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findBy(["library" => $request->attributes->get("library")]),
            'library' => $request->attributes->get("passedLibraryEntity")
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book(["library" => $request->attributes->get("passedLibraryEntity") ]);
        $form = $this->createForm(BookType::class, $book, ['library' => $request->attributes->get("library")]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->save($book, true);

            return $this->redirectToRoute('app_book_index', ["library" => $request->attributes->get("library")], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'library' => $request->attributes->get("passedLibraryEntity"),
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Request $request, Book $book): Response
    {
        if($book->getLibrary()->getId() != $request->attributes->get("library")){
            return $this->redirectToRoute('app_book_index', ['library' => $request->attributes->get("library")], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if($book->getLibrary()->getId() != $request->attributes->get("library")){
            return $this->redirectToRoute('app_book_index', ['library' => $request->attributes->get("library")], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->save($book, true);

            return $this->redirectToRoute('app_book_index', ['library' => $request->attributes->get("library")], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if($book->getLibrary()->getId() != $request->attributes->get("library")) {
            return $this->redirectToRoute('app_book_index', ['library' => $request->attributes->get("library")], Response::HTTP_SEE_OTHER);
        }

        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_book_index', ["library" => $request->attributes->get("library")], Response::HTTP_SEE_OTHER);
    }
}
