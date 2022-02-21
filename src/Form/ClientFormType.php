<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[])
            ->add('prenom',TextType::class,[
                'required' => false,
            ])
            ->add('email', EmailType::class,[
                'required' => false,
            ])
            ->add('telephone', NumberType::class,[
                'required' => false,
            ])
            ->add('adresse',TextType::class)
            ->add('codePostal', NumberType::class)
            ->add('ville',TextType::class)
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre',
                'choices'  => [
                    'Homme' => "homme",
                    'Femme' => "femme",
                ],
            ])
            ->add('enregistrer',SubmitType::class,[
                'label' => 'Enregistrer'
            ])
            ->add('mensuration',SubmitType::class,[
                'label' => 'Prise de mensuration'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
