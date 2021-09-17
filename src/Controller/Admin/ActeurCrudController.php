<?php

namespace App\Controller\Admin;

use App\Entity\Acteur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActeurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Acteur::class;
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
