<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController
{
    #[Route('/hello/world', name: 'hello_world')]
    public function index(): Response
    {
        //return new Response('');

        $gershtdfyuik = 'Hellow world';
        $texte = 'Bonjour je suis du texte';

        $list = [
            'un',
            'deux',
            'trois',
            'quatre',
        ];

        return $this->render('hello_world/index.html.twig', [
            'titre' => $gershtdfyuik,
            'text'  => $texte,
            'list'  => $list,
        ]);
    }

    #[Route('/person', name: 'app_person')]
    public function person(): Response
    {
        $person = new Person();
        $person->id = 1;
        $person->firstname = 'kévin';
        $person->name = 'michu';
        $person->sanitaryPass = false;

        dd($person);
    }

    #[Route('/add/contact', name: 'app_add_contact')]
    public function addContact(EntityManagerInterface $em): Response
    {
       $contact = new Contact();
       $contact->setFirstname('Johnny');
       $contact->setName('Bigoude');
       $contact->setSanitaryPass(false);

       $em->persist($contact);
       $em->flush();

       dd($contact);
    }
}
