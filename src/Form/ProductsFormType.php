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
                'required' => false,
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'choices'  => [
                    'n/a' => 'n/a',
                    'Man' => "m",
                    'Wonam' => "f",
                ],
                'placeholder' => 'Choice Gender',
                'required' => false,
            ])
            ->add('price',NumberType::class)
            ->add('code',TextType::class)
            ->add('designation',TextType::class)
            ->add('categories',EntityType::class, [
                'label' => 'Type',
                'class' => Categories::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choice Type',
            ])
            ->add('save',SubmitType::class)
            ->add('saveAndNew',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
