<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact/list', name: 'contact_list')]
    public function index(EntityManagerInterface $em): Response
    {
        $contacts = $em->getRepository(Contact::class)->findAll();

        return $this->render('contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    #[Route('/contact/detail/{id}', name: 'contact_detail')]
    public function detail(ContactRepository $contactRepo, $id): Response
    {
        $contact = $contactRepo->findOneById($id);

        return $this->render('contact/detail.html.twig', [
            'contact' => $contact,
        ]);
    }

    /*
     * Une autre manière de récuperer l'entité directement (paramConverter)
     *
    #[Route('/contact/detail/{id}', name: 'contact_detail')]
    public function detail(Contact $contact): Response
    {
        return $this->render('contact/detail.html.twig', [
            'contact' => $contact,
        ]);
    }
    */

    #[Route('/contact/add', name: 'contact_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        // permet de retrouver toutes les variables $_POST
        $params = $request->request->all();

        //recupere $_POST['name']
        //$request->request->get('name');

        // permet de retrouver toutes les variables $_GET
        //$request->query->all();

        // si le tableau $params n'est pas vide, ça veut dire que des
        // données ont été envoyées via le formulaire
        if (!empty($params)) {
            $contact = new Contact();
            $contact->setFirstname($params['firstname']);
            $contact->setPassword($params['password']);
            $contact->setEmail($params['email']);
            $contact->setName($params['name']);
            $contact->setSanitaryPass(isset($params['sanitaryPass']));

            /* // methode équivalente
            if (isset($params['sanitaryPass'])) {
                $contact->setSanitaryPass(true);
            } else {
                $contact->setSanitaryPass(false);
            }
            */

            // persist correspond à un INSERT INTO
            $em->persist($contact);
            $em->flush();

            // cette methode (provenant de AbstractController) permet d'effectuer
            // une redirection vers une autre page.
            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/add.html.twig');
    }

    #[Route('/contact/delete/{id}', name: 'contact_delete')]
    public function delete(EntityManagerInterface $em, Contact $contact): Response
    {
        // supprime le contact de la BDD
        $em->remove($contact);
        $em->flush();

        return $this->redirectToRoute('contact_list');
    }

    #[Route('/contact/update/{id}', name: 'contact_update')]
    public function update(EntityManagerInterface $em, Contact $contact, Request $request): Response
    {
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //sauvegarder les modifications faites dans $contact en bdd
            $em->flush();

            return $this->redirectToRoute('contact_list');
        }

        return $this->render('contact/update.html.twig', [
            'contact' => $contact,
            'form'    => $form->createView(),
        ]);
    }
}
