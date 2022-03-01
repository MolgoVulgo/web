<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Types;
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
            ->add('taille',TextType::class,[
                'required' => false,
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices'  => [
                    'Homme' => "m",
                    'Femme' => "f",
                ],
                'placeholder' => 'Choisir Genre',
                'required' => false,
            ])
            ->add('prix',NumberType::class)
            ->add('code',TextType::class)
            ->add('designation',TextType::class)
            ->add('types',EntityType::class, [
                'label' => 'Type',
                'class' => Types::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t');
                },
                'choice_label' => 'nom',
                'placeholder' => 'Choisir Type',
            ])
            ->add('enregistrer',SubmitType::class)
            ->add('enregistrerEtNouveau',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
