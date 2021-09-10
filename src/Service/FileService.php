<?php

namespace App\Service;

use App\Interfaces\FilableInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    private $projectDir;

    //https://symfony.com/doc/current/components/dependency_injection.html
    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->projectDir = $parameterBag->get('kernel.project_dir');
    }

    public function upload(UploadedFile $file, FilableInterface $entity, string $propertyName): void
    {
        $publicDir = $this->projectDir . '/public';
        $fileDir   = $entity->getFileDirectory();
        $filename  = $file->getClientOriginalName();

        $file->move($publicDir.$fileDir, $filename);

        $setter = 'set'.ucfirst($propertyName);
        $entity->$setter($fileDir.'/'.$filename);
    }
}