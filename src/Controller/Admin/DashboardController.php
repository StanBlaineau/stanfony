<?php

namespace App\Controller\Admin;

use App\Entity\Acteur;
use App\Entity\Film;
use App\Entity\Realisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony5');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Acteur', 'fas fa-user', Acteur::class);
        yield MenuItem::linkToCrud('Réalisateur', 'fas fa-video', Realisateur::class);
        yield MenuItem::linkToCrud('Film', 'fas fa-film', Film::class);
    }
}
