<?php

namespace App\Controller;

use App\Entity\Acteur;
use App\Entity\Film;
use App\Entity\Realisateur;
use App\Entity\User;
use App\Form\ActeurType;
use App\Form\FilmType;
use App\Form\RealisateurType;
use App\Repository\FilmRepository;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/film', name: 'film_')]
class FilmController extends AbstractController
{
    #[Route('/acteur', name: 'acteur')]
    public function acteur(Request $request, EntityManagerInterface $em): Response
    {
        $acteur = new Acteur();
        $form = $this->createForm(ActeurType::class, $acteur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($acteur);
            $em->flush();

            return $this->redirectToRoute('film_acteur');
        }

        $entities = $em->getRepository(Acteur::class)->findAll();

        return $this->render('film/personne.html.twig', [
            'form' => $form->createView(),
            'entity_type' => 'Acteur',
            'entities' => $entities,
        ]);
    }

    #[Route('/realisateur', name: 'realisateur')]
    public function realisateur(Request $request, EntityManagerInterface $em): Response
    {
        $realisateur = new Realisateur();
        $form = $this->createForm(RealisateurType::class, $realisateur);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($realisateur);
            $em->flush();

            return $this->redirectToRoute('film_realisateur');
        }

        $entities = $em->getRepository(Realisateur::class)->findAll();

        return $this->render('film/personne.html.twig', [
            'form' => $form->createView(),
            'entity_type' => 'Réalisateur',
            'entities' => $entities,
        ]);
    }

    #[Route('/', name: 'film')]
    public function film(Request $request, EntityManagerInterface $em, FileService $fileService): Response
    {
        //$user = $this->getUser();
        //dd($user->getRoles());
/*
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('contact_list');
        }
*/
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //getData retourne l'entitée Film
            /** @var Film $film */
            $film = $form->getData();

            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            $fileService->upload($file, $film, 'image');

            $em->persist($film);
            $em->flush();

            return $this->redirectToRoute('film_film');
        }

        $films = $em->getRepository(Film::class)->findAll();

        return $this->render('film/index.html.twig', [
            'form' => $form->createView(),
            'films' => $films,
        ]);
    }

    #[Route('/search', name: 'search')]
    public function search(): Response
    {
        $form =  $this->createFormBuilder()
            ->add('strSearch', TextType::class, [
                'label' => 'Rechercher',
                'required' => false,
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('acteur', EntityType::class, [
                'class' => Acteur::class,
                'choice_label' => 'fullname',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, ['label' => 'chercher'])
            ->getForm();

        return $this->render('film/film.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/search/response', name: 'search_response')]
    public function searchResponse(Request $request, FilmRepository $filmRepository): Response
    {
        $form = $request->request->all();

        $films = $filmRepository->search($form['form']);

        // retourne le code html de la vue
        $view = $this->renderView('film/_search.html.twig', [
            'films' => $films,
        ]);

        // retourne une JsonResponse
        return $this->json([
            'view' => $view,
        ]);
    }
}
