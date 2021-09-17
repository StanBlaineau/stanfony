<?php

namespace App\Controller\Admin;

use App\Entity\Realisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RealisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Realisateur::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
