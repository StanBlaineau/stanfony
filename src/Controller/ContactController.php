<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact/list', name: 'contact_list')]
    public function index(EntityManagerInterface $em): Response
    {
        $contacts = '';

        return $this->render('contact/index.html.twig', [
            'contact' => $contacts,
        ]);
    }
}
