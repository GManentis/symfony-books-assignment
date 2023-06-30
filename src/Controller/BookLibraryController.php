<?php

namespace App\Controller;

use App\Entity\BookLibrary;
use App\Form\BookLibraryType;
use App\Repository\BookLibraryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/library/{library}/book')]
class BookLibraryController extends AbstractController
{
    #[Route('/', name: 'app_book_library_index', methods: ['GET'])]
    public function index(Request $request, BookLibraryRepository $bookLibraryRepository): Response
    {
        return $this->render('book_library/index.html.twig', [
            'book_libraries' => $bookLibraryRepository->findBy(["library" => $request->attributes->get('passedLibraryEntity')->getId()]),
            'library' => $request->attributes->get('passedLibraryEntity')
        ]);
    }

    #[Route('/new', name: 'app_book_library_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookLibraryRepository $bookLibraryRepository): Response
    {
        $bookLibrary = new BookLibrary();
        $bookLibrary->setLibrary($request->attributes->get('passedLibraryEntity'));
        $form = $this->createForm(BookLibraryType::class, $bookLibrary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookLibraryRepository->save($bookLibrary, true);

            return $this->redirectToRoute('app_book_library_index', ["library" => $request->attributes->get('passedLibraryEntity')->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_library/new.html.twig', [
            'book_library' => $bookLibrary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_library_show', methods: ['GET'])]
    public function show(Request $request, BookLibrary $bookLibrary): Response
    {
        if($bookLibrary->getLibrary()->getId() !== $request->attributes->get('passedLibraryEntity')->getId()){
            throw new NotFoundHttpException("Library id mismatch");
        }

        return $this->render('book_library/show.html.twig', [
            'book_library' => $bookLibrary,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_library_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BookLibrary $bookLibrary, BookLibraryRepository $bookLibraryRepository): Response
    {
        if($bookLibrary->getLibrary()->getId() !== $request->attributes->get('passedLibraryEntity')->getId()){
            throw new NotFoundHttpException("Library id mismatch");
        }

        $form = $this->createForm(BookLibraryType::class, $bookLibrary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookLibraryRepository->save($bookLibrary, true);

            return $this->redirectToRoute('app_book_library_index', ["library" => $request->attributes->get('passedLibraryEntity')->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book_library/edit.html.twig', [
            'book_library' => $bookLibrary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_library_delete', methods: ['POST'])]
    public function delete(Request $request, BookLibrary $bookLibrary, BookLibraryRepository $bookLibraryRepository): Response
    {
        if($bookLibrary->getLibrary()->getId() !== $request->attributes->get('passedLibraryEntity')->getId()){
            throw new NotFoundHttpException("Library id mismatch");
        }

        if ($this->isCsrfTokenValid('delete'.$bookLibrary->getId(), $request->request->get('_token'))) {
            $bookLibraryRepository->remove($bookLibrary, true);
        }

        return $this->redirectToRoute('app_book_library_index', ["library" => $request->attributes->get('passedLibraryEntity')->getId()], Response::HTTP_SEE_OTHER);
    }
}
