<?php

namespace App\Form;

use App\Entity\Customers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[])
            ->add('firstName',TextType::class,[
                'required' => false,
            ])
            ->add('email', EmailType::class,[
                'required' => false,
            ])
            ->add('phone', NumberType::class,[
                'required' => false,
            ])
            ->add('address',TextType::class)
            ->add('zipCode', NumberType::class)
            ->add('city',TextType::class)
            ->add('gender', ChoiceType::class, [
                'label' => 'Gender',
                'choices'  => [
                    'Homme' => "m",
                    'Femme' => "f",
                ],
                'placeholder' => 'Choisir Gender',
            ])
            ->add('enregistrer',SubmitType::class,[
                'label' => 'Enregistrer'
            ])
            ->add('measurement',SubmitType::class,[
                'label' => 'Prise de measurement '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customers::class,
        ]);
    }
}
