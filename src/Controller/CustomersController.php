<?php

namespace App\Controller;

use App\Entity\Customers;
use App\Entity\Measurement ;
use App\Form\CustomerFormType;
use App\Form\MeasurementFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;

class CustomersController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }


    #[Route('/customers', name: 'customers')]
    public function customers(Request $request, DataTableFactory $dataTableFactory): Response
    {

        $table = $dataTableFactory->create()
        ->add('name', 
                TextColumn::class,   
                    [
                    'label' => 'Nom',
                    'globalSearchable' => true,
                    ])
        ->add('countryId', 
                TextColumn::class, 
                    [
                    'label' => 'Lieux',
                    'field' => 'country.name',
                    ])
        ->add('phone', 
                TextColumn::class,
                    [
                    'label' => 'Téléphone',
                    ])
        ->add('email', 
                TextColumn::class, 
                    [
                    'label' => 'E-mail',
                    ])       
        ->add('action', 
                TextColumn::class,
                    [
                    'label' => 'Action',
                    'render' => function($value, $context) {
                        $url = $this->generateUrl('event_view', array('eventId' => $context->getId()));
                        $url2 = $this->generateUrl('customer_edit', array('customer' => $context->getId()));
                        return sprintf('<a href="%s">Voir</a> - <a href="%s">Modifier</a>', $url, $url2);
                        }
                    ])

        ->createAdapter(ORMAdapter::class, [
            'entity' => Customers::class,
        ])
        ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('customers.html.twig', [
            'datatable' => $table,
        ]);
    }

    #[Route('/customer/add', name: 'customer_add')]
    public function customerAdd(Request $request): Response
    {

        $customer = new Customers;
        $customerForm = $this->createForm(
            CustomerFormType::class, 
            $customer, 
            [
                'action' => $this->generateUrl('customer_add'),
            ]
        );

        $customerForm->handleRequest($request);
        if ($customerForm->isSubmitted() && $customerForm->isValid()) {

            $customer = $customerForm->getData();
            $this->em->persist($customer);
            $this->em->flush();
            
            if ($customerForm->getClickedButton() === $customerForm->get('measurement')){
                return $this->redirectToRoute('customer_measurement', [
                    'customer' => $customer->getId(),
                ]);
            }

            return $this->redirectToRoute('customers', []);
        }

        return $this->render('customers/customerAdd.html.twig', [
            'customerForm' => $customerForm->createView(),
        ]);
    }

    #[Route('/customer/{customer}/edit', name: 'customer_edit')]
    public function customerEdit(Request $request, Customers $customer) : Response
    {

        //$customer = $this->em->getRepository(customers::class)->find($customer);
        $customerForm = $this->createForm(
            CustomerFormType::class, 
            $customer, 
            [
                'action' => $this->generateUrl('customer_edit',['customer' => $customer->getId()]),
            ]
        );

        $customerForm->handleRequest($request);
        if ($customerForm->isSubmitted() && $customerForm->isValid()) {

            $customer = $customerForm->getData();
            $this->em->persist($customer);
            $this->em->flush();

            if ($customerForm->getClickedButton() === $customerForm->get('measurement')){
                return $this->redirectToRoute('customer_measurement', [
                    'customer' => $customer->getId(),
                ]);
            }

            return $this->redirectToRoute('customers');
        }

        return $this->render('customers/customerAdd.html.twig', [
            'customerForm' => $customerForm->createView(),
        ]);
    }



    #[Route('/customers/{customer}/measurement', name: 'customer_measurement')]
    public function customerMeasurement (Request $request,Customers $customer): Response
    {
                
        
        
        if (is_null($customer->getMeasurement ())) {
            $measurement= new Measurement ;
        }else{
            $measurement= $this->em->getRepository(Measurement::class)->find($customer->getMeasurement()->getId());
            //$measurement= new Measurement ;
        }
            
//dd($measurement);

        $measurementForm = $this->createForm(
            MeasurementFormType::class, 
            $measurement, 
            [
                'action' => $this->generateUrl('customer_measurement',['customer' => $customer->getId()]),
                'gender' => $customer->getGender(),
            ]
        );

        $measurementForm->handleRequest($request);
        if ($measurementForm->isSubmitted() && $measurementForm->isValid()) {

            $measurement= $measurementForm->getData();
            $customer->setMeasurement ($measurement);
            $this->em->persist($customer);
            $this->em->flush();

        }

        if ($customer->getGender() == 'male') {
            $template = 'customers/measurement_m.html.twig';
        }else{
            $template = 'customers/measurement_w.html.twig';
        }

        return $this->render($template, [
            'measurementForm' => $measurementForm->createView(),
            'gender' => $customer->getGender(),
        ]);
    }

}
