<?php

namespace App\Form;

use App\Entity\Measurement ;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->gender = $options['gender'];

        $builder
            ->add('hauteurTailleSol', NumberType::class,[
                'required' => true
            ])
            ->add('longueurBasLegerementPlie', NumberType::class,[
                'required' => true
            ])
            ->add('hauteurEncolureSol', NumberType::class,[
                'required' => true
            ])
            ->add('Taille', NumberType::class,[
                'required' => true
            ])
            ->add('tourCou', NumberType::class,[
                'required' => true
            ])
            ->add('carrureDevant', NumberType::class,[
                'required' => true
            ])
            ->add('carrureDos', NumberType::class,[
                'required' => true
            ])
            ->add('tourTaille', NumberType::class,[
                'required' => true
            ])
            ->add('tourHanche', NumberType::class,[
                'required' => true
            ])
            ->add('tourBassin', NumberType::class,[
                'required' => true
            ])
            ->add('tourGenou', NumberType::class,[
                'required' => true
            ])
            ->add('tourChecity', NumberType::class,[
                'required' => true
            ])
            ->add('hauteurEcolureTailleDevant', NumberType::class,[
                'required' => true
            ])
            ->add('hauteurEncolurSaillant', NumberType::class,[
                'required' => true
            ])
            ->add('hauteurTailleGenou', NumberType::class,[
                'required' => true
            ])
            ->add('tourBiceps', NumberType::class,[
                'required' => true
            ])
            ->add('tourAvantBras', NumberType::class,[
                'required' => true
            ])
            ->add('tourPoignet', NumberType::class,[
                'required' => true
            ])
            ->add('tourCuisse', NumberType::class,[
                'required' => true
            ])
            ->add('tourMollet', NumberType::class,[
                'required' => true
            ])
            ->add('hauteurEncolureTailleDos', NumberType::class,[
                'required' => true
            ])
            ->add('save', SubmitType::class)
            ->add('products', SubmitType::class);
            // femme selement
            if($this->gender == 'femme'){
                $builder->add('tourPoitrine', NumberType::class,[
                    'required' => true
                ])
                    ->add('encartSaillantPoitrine', NumberType::class,[
                        'required' => true
                    ])
                    ->add('tourSousPoitrine', NumberType::class,[
                        'required' => true
                    ]);
            }    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement ::class,
            'gender' => null,
        ]);
    }
}
