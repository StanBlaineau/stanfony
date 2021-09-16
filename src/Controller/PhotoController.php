<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PhotoController extends AbstractController
{
    #[Route('/photo', name: 'photo')]
    public function index(HttpClientInterface $client): Response
    {
        $method = 'GET';
        $url    = 'https://picsum.photos/v2/list';

        $response = $client->request($method, $url);

        $status  = $response->getStatusCode();
        $content = $response->getContent();

        $photos = json_decode($content);

        return $this->render('photo/index.html.twig', [
            'photos' => $photos,
        ]);
    }
}
