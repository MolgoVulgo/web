<?php

namespace App\Controller;

use App\Entity\Customers;
use App\Entity\Mensuration;
use App\Form\CustomerFormType;
use App\Form\MensurationFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Datatables\CustomersDatatable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sg\DatatablesBundle\Datatable\DatatableFactory;
use Sg\DatatablesBundle\Response\DatatableResponse;

class CustomersController extends AbstractController
{

    private $dtFactory;
    private $dtResponse;
    private $em;

    public function __construct(EntityManagerInterface $entityManager,DatatableFactory $datatableFactory, DatatableResponse $datatableResponse)
    {
        $this->dtFactory = $datatableFactory;
        $this->dtResponse = $datatableResponse;
        $this->em = $entityManager;
    }


    #[Route('/customers', name: 'customers')]
    public function customers(): Response
    {

        /** @var DatatableInterface $CustomersDatatable */
        $customerDatatable = $this->dtFactory->create(CustomersDatatable::class);
        $customerDatatable->buildDatatable();

        return $this->render('customers.html.twig', [
            'customerDatatable' => $customerDatatable,
        ]);
    }

    #[Route('/customers/list', name: 'customer_list')]
    public function customersList(Request $request): Response
    {
        /** @var DatatableInterface $CustomersDatatable */
        $datatable = $this->dtFactory->create(CustomersDatatable::class);
        $datatable->buildDatatable();
        $responseService = $this->dtResponse;
        $responseService->setDatatable($datatable);
        $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
        $datatableQueryBuilder->getQb();
        return $responseService->getResponse();
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
            
            if ($customerForm->getClickedButton() === $customerForm->get('mensuration')){
                return $this->redirectToRoute('customer_mensuration', [
                    'customer' => $customer->getId(),
                ]);
            }

        }

        return $this->render('customers/customerAdd.html.twig', [
            'customerForm' => $customerForm->createView(),
        ]);
    }

    #[Route('/customer/{customer}/edit', name: 'customer_edit')]
    public function customerEdit(Request $request, Customers $customer) : Response
    {

        $customer = $this->em->getRepository(customers::class)->find($customer);
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

            if ($customerForm->getClickedButton() === $customerForm->get('mensuration')){
                return $this->redirectToRoute('customer_mensuration', [
                    'customer' => $customer->getId(),
                ]);
            }

            return $this->redirectToRoute('customers');
        }

        return $this->render('customers/customerAdd.html.twig', [
            'customerForm' => $customerForm->createView(),
        ]);
    }



    #[Route('/customers/{customer}/mensuration', name: 'customer_mensuration')]
    public function customerMensuration(Request $request,Customers $customer): Response
    {
        
        $mensuration = $customer->getMensuration();
        if (is_null($mensuration)) {
            $mensuration = new Mensuration;
        }
            
        $mensurationForm = $this->createForm(
            MensurationFormType::class, 
            $mensuration, 
            [
                'action' => $this->generateUrl('customer_mensuration',['customer' => $customer->getId()]),
                'genre' => $customer->getGenre(),
            ]
        );

        $mensurationForm->handleRequest($request);
        if ($mensurationForm->isSubmitted() && $mensurationForm->isValid()) {

            $mensuration = $mensurationForm->getData();
            $customer->setMensuration($mensuration);
            $this->em->persist($customer);
            $this->em->flush();

        }

        return $this->render('customers/mensuration.html.twig', [
            'mensurationForm' => $mensurationForm->createView(),
            'genre' => $customer->getGenre(),
        ]);
    }

}
