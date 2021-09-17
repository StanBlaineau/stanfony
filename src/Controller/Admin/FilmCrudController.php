<?php

namespace App\Controller\Admin;

use App\Entity\Film;
use App\Service\FileService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilmCrudController extends AbstractCrudController
{
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public static function getEntityFqcn(): string
    {
        return Film::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fileService = $this->fileService;

        yield IdField::new('id')->onlyOnIndex();
        yield TextField::new('titre');
        yield DateField::new('annee')->setFormTypeOptions([
            'html5' => true,
            'widget' => 'single_text',
        ]);
        yield TextEditorField::new('synopsis');
        yield IntegerField::new('duree');

        yield ImageField::new('image')
            ->setUploadedFileNamePattern(function (UploadedFile $uploadedFile) use ($fileService): string { return $fileService->getSafeFileName($uploadedFile); })
            ->setUploadDir('/public'.Film::FILE_DIR)
            ->setBasePath(Film::FILE_DIR)
        ;

        yield AssociationField::new('realisateur')->setColumns(6);
        yield AssociationField::new('acteurs')->setColumns(6);
    }
}
