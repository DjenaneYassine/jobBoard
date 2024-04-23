<?php

namespace App\Form;

use App\Entity\Offre;
use App\Entity\Service;
use App\Entity\Tag;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TypeTextType::class,[
                'label' => "Nom de l'offre",
                'attr' => [
                    'class' => "border border-indigo-400 ml-2"
                ]
            ])
            ->add('description', TextareaType::class,[
                'label' => "Description de l'offre",
                'attr' => [
                    'class' => "border border-indigo-400 ml-2"
                ]
            ])
            ->add('salaire', TypeTextType::class, [
                'label' => "Salaire",
                'attr' => [
                    'class' => "border border-indigo-400 ml-2"
                ]
            ])
            ->add('service', EntityType::class, [
                'class' => Service::class,
                'choice_label' => 'nom',
                'label' => "Le service de l'offre",
                'attr' => [
                    'class' => "border border-indigo-400 ml-2"
                ]
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'label' => "Le tag de l'offre",
                'attr' => [
                    'class' => "border border-indigo-400 ml-2"
                ]

            ])
            ->add('submit', SubmitType::class, [
                'label' => "Créer l'offre",
                'attr' => [
                    'class' => "border bg-indigo-100 p-2"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
