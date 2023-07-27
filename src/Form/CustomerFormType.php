<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Customers;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('name',TextType::class,[
                'label' => 'Nom'
            ])
            ->add('firstName',TextType::class,[
                'label' => 'Prénom',
                'required' => false,
            ])
            ->add('email', EmailType::class,[
                'required' => false,
            ])
            ->add('phone', NumberType::class,[
                'label' => 'GSM',
                'required' => false,
            ])
            ->add('address',TextType::class,[
                'label' => 'Adresse',
            ])
            ->add('zipCode', NumberType::class,[
                'label' => 'Code Postal',
            ])
            ->add('city',TextType::class,[
                'label' => 'Ville',
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'choices'  => [
                    'Homme' => "m",
                    'Femme' => "f",
                ],
                'placeholder' => 'Choix',
            ])
            ->add('country',EntityType::class, [
                'label' => 'Pays',
                'class' => Country::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choix',
            ])
            ->add('save',SubmitType::class,[
                'label' => 'Sauvegarde'
            ])
            ->add('measurement',SubmitType::class,[
                'label' => 'Prise de mesure'
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
