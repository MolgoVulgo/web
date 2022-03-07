<?php

namespace App\Form;

use App\Entity\Customers;
use App\Entity\Events;
use App\Entity\Invoices;
use App\Form\InvoicelinesFormType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoicesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer',EntityType::class, [
                'label' => 'Customers',
                'class' => Customers::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choice Name',
            ])
            ->add('events',EntityType::class, [
                'label' => 'Events',
                'class' => Events::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e');
                },
                'choice_label' => 'name',
                'placeholder' => 'Choice Name',
            ])
            ->add('invoiceLines',CollectionType::class,[
                'entry_type' => InvoicelinesFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('Save',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoices::class,
        ]);
    }
}
