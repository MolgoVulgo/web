<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Evenements;
use App\Entity\Produits;
use App\Entity\Ventes;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VentesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client',EntityType::class, [
                'label' => 'Clients',
                'class' => Clients::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom',
                'placeholder' => 'Choisir Nom',
            ])
            ->add('events',EntityType::class, [
                'label' => 'Evenements',
                'class' => Evenements::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e');
                },
                'choice_label' => 'nom',
                'placeholder' => 'Choisir Nom',
            ])
            ->add('produits',EntityType::class, [
                'label' => 'Produits',
                'class' => Produits::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p');
                },
                'choice_label' => 'designation',
                'placeholder' => 'Choisir Produit',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ventes::class,
        ]);
    }
}
