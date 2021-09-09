<?php

namespace App\Form;

use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('annee', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Année',
            ])
            ->add('synopsis')
            ->add('duree', null, ['label' => 'Durée (en secondes)'])
            ->add('acteurs')
            ->add('realisateur')
            ->add('file', FileType::class, [
                'mapped' => false,
                'label' => 'Affiche',
            ])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
