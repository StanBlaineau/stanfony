<?php

namespace App\Controller;

use App\Service\ChuckService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChuckController extends AbstractController
{
    #[Route('/chuck', name: 'chuck_index')]
    public function index(ChuckService $chuckService): Response
    {
        $result = $chuckService->getCategories();

        if ($result['error']) {
            $this->addFlash('error', $result['errorMsg']);
        }

        return $this->render('chuck/index.html.twig', [
            'categories' => $result['content'],
        ]);
    }

    #[Route('/chuck/categories/{category}', name: 'chuck_categories')]
    public function categories(ChuckService $chuckService, string $category): Response
    {
        $result = $chuckService->getCategory($category);

        if ($result['error']) {
            $this->addFlash('error', $result['errorMsg']);
        }

        return $this->render('chuck/joke.html.twig', [
            'joke' => $result['content'],
        ]);
    }
}
