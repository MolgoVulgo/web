<?php

namespace App\Form;

use App\Entity\Customers;
use App\Entity\Events;
use App\Entity\Products;
use App\Entity\Sales;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer',EntityType::class, [
                'label' => 'Customers',
                'class' => Customers::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choisir Name',
            ])
            ->add('events',EntityType::class, [
                'label' => 'Events',
                'class' => Events::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choisir Name',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sales::class,
        ]);
    }
}
