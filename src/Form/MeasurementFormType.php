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
    private $gender;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->gender = $options['gender'];

        $builder
            ->add('hauteurTailleSol', NumberType::class,[
                'required' => false
            ])
            ->add('longueurBasLegerementPlie', NumberType::class,[
                'required' => false
            ])
            ->add('hauteurEncolureSol', NumberType::class,[
                'required' => false
            ])
            ->add('Taille', NumberType::class,[
                'required' => false
            ])
            ->add('tourCou', NumberType::class,[
                'required' => false
            ])
            ->add('carrureDevant', NumberType::class,[
                'required' => false
            ])
            ->add('carrureDos', NumberType::class,[
                'required' => false
            ])
            ->add('tourTaille', NumberType::class,[
                'required' => false
            ])
            ->add('tourHanche', NumberType::class,[
                'required' => false
            ])
            ->add('tourBassin', NumberType::class,[
                'required' => false
            ])
            ->add('tourGenou', NumberType::class,[
                'required' => false
            ])
            ->add('tourChecity', NumberType::class,[
                'required' => false
            ])
            ->add('hauteurEcolureTailleDevant', NumberType::class,[
                'required' => false
            ])
            ->add('hauteurEncolurSaillant', NumberType::class,[
                'required' => false
            ])
            ->add('hauteurTailleGenou', NumberType::class,[
                'required' => false
            ])
            ->add('tourBiceps', NumberType::class,[
                'required' => false
            ])
            ->add('tourAvantBras', NumberType::class,[
                'required' => false
            ])
            ->add('tourPoignet', NumberType::class,[
                'required' => false
            ])
            ->add('tourCuisse', NumberType::class,[
                'required' => false
            ])
            ->add('tourMollet', NumberType::class,[
                'required' => false
            ])
            ->add('hauteurEncolureTailleDos', NumberType::class,[
                'required' => false
            ])
            ->add('save', SubmitType::class)
            ->add('products', SubmitType::class);
            // femme selement
            if($this->gender == 'femme'){
                $builder->add('tourPoitrine', NumberType::class,[
                    'required' => false
                ])
                    ->add('encartSaillantPoitrine', NumberType::class,[
                        'required' => false
                    ])
                    ->add('tourSousPoitrine', NumberType::class,[
                        'required' => false
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
