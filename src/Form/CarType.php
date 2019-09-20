<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Owner;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', ChoiceType::class, [
                'label' => "Marque de la voiture",
                'choices' => [
                    "Renault" => "Renault",
                    "Peugeot" => "Peugeot",
                    "Citroen" => "Citroen",
                    "Toyota" => "Toyota"
                ]
            ])
            ->add('model', TextType::class, [
                'label' => "Modèle",
                'attr' => [
                    'placeholder' => "Modèle de voiture"
                ]
            ])
            ->add('category', TextType::class, [
                'label' => "Catégorie",
                'attr' => [
                    'placeholder' => "Catégorie de voiture"
                ]
            ])
            ->add('year', IntegerType::class, [
                'label' => "Année de mise en circulation"
            ])
            ->add('milage', TextType::class, [
                'label' => "Kilométrage",
                'attr' => [
                    'placeholder' => "Kilométrage maximum souhaité"
                ]
            ])
            ->add('price', TextType::class, [
                'label' => "Prix (€)",
                'attr' => [
                    'placeholder' => "Prix maximum souhaité"
                ]
            ])
            ->add('owner', EntityType::class, [
                'label' => "Propriétaire",
                'class' => Owner::class,
                'choice_label' => 'lastName',
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
