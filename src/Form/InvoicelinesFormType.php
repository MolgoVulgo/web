<?php

namespace App\Form;

use App\Entity\InvoiceLines;
use App\Entity\Products;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoicelinesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('products',EntityType::class, [
                'label' => 'Type',
                'class' => Products::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t');
                },
                'choice_label' => 'ref',
                'placeholder' => 'Choice Type',
                'attr' => [
                    'class' => 'product'
                ]
            ])
            ->add('quantity', NumberType::class,[
                'data' => '1',
                'attr' => [
                    'class' => 'quantity'
                ]
            ])
            ->add('price', NumberType::class,[
                'data' => '1',
                'attr' => [
                    'class' => 'price'
                ]
            ])
            ->add('discount', NumberType::class,[
                'data' => '0',
                'attr' => [
                    'class' => 'discount'
                ]
            ])
            ->add('subtotal', NumberType::class,[
                'mapped' => false,
                'attr' => [
                    'readonly' => true,
                    'data' => '0',
                    'class' => 'subtotal'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceLines::class,
        ]);
    }
}
