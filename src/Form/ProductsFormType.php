<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Categories;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref',TextType::class)
            ->add('height',TextType::class,[
                'label' => 'taille',
                'required' => false,
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'choices'  => [
                    'n/a' => 'n/a',
                    'Homme' => "m",
                    'Femme' => "f",
                ],
                'placeholder' => 'Choix Genre',
                'required' => false,
            ])
            ->add('price',NumberType::class,[
                'label' => 'Prix',
            ])
            ->add('code',TextType::class,[
                'label' => 'Code',
            ])
            ->add('designation',TextType::class,[
                'label' => 'Désignation',
            ])
            ->add('categories',EntityType::class, [
                'label' => 'Type',
                'class' => Categories::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choix Type',
            ])
            ->add('save',SubmitType::class,[
                'label' => 'Saugarder',
            ])
            ->add('saveAndNew',SubmitType::class,[
                'label' => 'Savegarder et nouveau',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
