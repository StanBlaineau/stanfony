<?php

namespace App\Controller;

use App\Entity\Page;
use App\Form\PageType;
use App\Repository\PageRepository;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/page')]
class AdminPageController extends AbstractController
{
    #[Route('/', name: 'page_index', methods: ['GET'])]
    public function index(PageRepository $pageRepository): Response
    {
        return $this->render('admin/page/index.html.twig', [
            'pages' => $pageRepository->findBy([], ['ordre' => 'asc']),
        ]);
    }

    #[Route('/new', name: 'page_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FileService $fileService): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Page $film */
            $page = $form->getData();

            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            if ($file) {
                $fileService->upload($file, $page, 'image');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($page);
            $entityManager->flush();

            return $this->redirectToRoute('page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/page/new.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'page_show', methods: ['GET'])]
    public function show(Page $page): Response
    {
        return $this->render('admin/page/show.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/{id}/edit', name: 'page_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Page $page, FileService $fileService): Response
    {
        $form = $this->createForm(PageType::class, $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Page $film */
            $page = $form->getData();

            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            if ($file) {
                $fileService->upload($file, $page, 'image');
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('page_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/page/edit.html.twig', [
            'page' => $page,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'page_delete', methods: ['POST'])]
    public function delete(Request $request, Page $page, FileService $fileService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$page->getId(), $request->request->get('_token'))) {
            //remove the image file
            $fileService->remove($page, 'image');

            //remove entity
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($page);
            $entityManager->flush();
        }

        return $this->redirectToRoute('page_index', [], Response::HTTP_SEE_OTHER);
    }
}
