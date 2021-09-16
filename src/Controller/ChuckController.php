<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChuckController extends AbstractController
{
    #[Route('/chuck', name: 'chuck_index')]
    public function index(HttpClientInterface $client): Response
    {
        $response = $client->request('GET',  'https://api.chucknorris.io/jokes/categories');
        $categories = json_decode($response->getContent());

        return $this->render('chuck/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/chuck/categories/{categorie}', name: 'chuck_categories')]
    public function categories(HttpClientInterface $client, string $categorie): Response
    {
        $response = $client->request('GET', 'https://api.chucknorris.io/jokes/random?category='.$categorie);
        $joke = json_decode($response->getContent());

        return $this->render('chuck/joke.html.twig', [
            'joke' => $joke,
        ]);
    }
}
