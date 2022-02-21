<?php

namespace App\Form;

use App\Entity\Mensuration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MensurationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->genre = $options['genre'];

        dump($options);

        $builder
            ->add('hauteurTailleSol', NumberType::class)
            ->add('longueurBasLegerementPlie', NumberType::class)
            ->add('hauteurEncolureSol', NumberType::class)
            ->add('taille', NumberType::class)
            ->add('tourCou', NumberType::class)
            ->add('carrureDevant', NumberType::class)
            ->add('carrureDos', NumberType::class)
            ->add('tourTaille', NumberType::class)
            ->add('tourHanche', NumberType::class)
            ->add('tourBassin', NumberType::class)
            ->add('tourGenou', NumberType::class)
            ->add('tourCheville', NumberType::class)
            ->add('hauteurEcolureTailleDevant', NumberType::class)
            ->add('hauteurEncolurSaillant', NumberType::class)
            ->add('hauteurTailleGenou', NumberType::class)
            ->add('tourBiceps', NumberType::class)
            ->add('tourAvantBras', NumberType::class)
            ->add('tourPoignet', NumberType::class)
            ->add('tourCuisse', NumberType::class)
            ->add('tourMollet', NumberType::class)
            ->add('hauteurEncolureTailleDos', NumberType::class);
            // femme selement
            if($this->genre == 'femme'){
                $builder->add('tourPoitrine', NumberType::class)
                    ->add('encartSaillantPoitrine', NumberType::class)
                    ->add('tourSousPoitrine', NumberType::class);
            }    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mensuration::class,
            'genre' => null,
        ]);
    }
}
