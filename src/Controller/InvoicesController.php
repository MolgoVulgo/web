<?php

namespace App\Controller;

use App\Entity\Events;
use App\Entity\Invoices;
use App\Form\InvoicesFormType;
use App\Form\OrdersFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;


class InvoicesController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    #[Route('/invoices', name: 'invoices')]
    public function invoices(Request $request, DataTableFactory $dataTableFactory): Response
    {
        
        $table = $dataTableFactory->create()
            ->add('customer', 
                    TextColumn::class,   
                        [
                        'label' => 'Client',
                        'field' => 'c.name',
                        'globalSearchable' => true,
                        ])
            ->add('events', 
                    TextColumn::class, 
                        [
                        'label' => 'Lieux',
                        'field' => 'e.name'
                        ])
            ->add('date', 
                    DateTimeColumn::class, 
                        [
                        'label' => 'Date',
                        'format' => 'd-m-Y'
                        ])
            ->add('quantity', 
                    TextColumn::class,
                        [
                        'label' => 'Quantité',
                        ])
            ->add('total', 
                    TextColumn::class,
                        [
                        'label' => 'Total',
                        ])            
            ->add('action', 
                    TextColumn::class,
                        [
                        'label' => 'Action',
                        'render' => function($value, $context) {
                            $url = $this->generateUrl('invoice_view', array('invoice' => $context->getId()));
                            $url2 = $this->generateUrl('invoice_view', array('invoice' => $context->getId()));
                            return sprintf('<a href="%s">Voir</a> - <a href="%s">Modifier</a>', $url, $url2);
                            }
                        ])

            ->createAdapter(ORMAdapter::class, [
                'entity' => Invoices::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('i')
                        ->addSelect('e')
                        ->from(Invoices::class, 'i')
                        ->innerJoin('i.events', 'e')
                        ->innerJoin('i.customer','c')
                        ->andWhere('i.type=1')
                    ;
                },
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('invoices.html.twig', [
            'datatable' => $table
        ]);
    }    
    
    #[Route('/invoices/{invoice}/view', name: 'invoice_view')]
    public function invoiceView(Invoices $invoice): Response
    {
        return $this->render('invoices/invoiceView.html.twig', [
            'invoice' => $invoice,
        ]);
    }  

    #[Route('/invoices/add', name: 'invoices_add')]
    public function invoicesAdd(Request $request): Response
    {

        $invoices = new Invoices;
        $invoicesForm = $this->createForm(
            InvoicesFormType::class, 
            $invoices, 
            [
                'action' => $this->generateUrl('invoices_add'),
            ]
        );

        $invoicesForm->handleRequest($request);
        if ($invoicesForm->isSubmitted() && $invoicesForm->isValid()) {

            $invoices = $invoicesForm->getData();
            
            // count total Invoces and total article
            $total= 0;
            $quantity = 0;
            foreach ($invoices->getInvoiceLines() as $invoiceLine) {

                $total = $total + $invoiceLine->getPrice();
                $quantity = $quantity + $invoiceLine->getQuantity();
            }
            $invoices->setTotal($total);
            $invoices->setQuantity($quantity);
            $invoices->setDate(new \DateTime("NOW"));
            $invoices->setType(1);
            $this->em->persist($invoices);
            $this->em->flush();
        }

        return $this->render('invoices/invoicesAdd.html.twig', [
            'invoicesForm' => $invoicesForm->createView(),
        ]);
    }

    #[Route('/invoices/add/{eventId}', name: 'event_invoices_add')]
    public function EventInvoicesAdd($eventId,Request $request): Response
    {
        $invoices = new Invoices;
        $invoices->setEvents($this->em->getRepository(Events::class)->find($eventId));

        $invoicesForm = $this->createForm(
            InvoicesFormType::class, 
            $invoices, 
            [
                'action' => $this->generateUrl('invoices_add',['eventId' => $eventId]),
            ]
        );

        $invoicesForm->handleRequest($request);
        if ($invoicesForm->isSubmitted() && $invoicesForm->isValid()) {

            $invoices = $invoicesForm->getData();
            $invoices->setDate(new \DateTime("NOW"));
            $this->em->persist($invoices);
            $this->em->flush();
        }

        return $this->render('invoices/invoicesAdd.html.twig', [
            'invoicesForm' => $invoicesForm->createView(),
        ]);
    }


    #[Route('/orders', name: 'orders')]
    public function orders(Request $request, DataTableFactory $dataTableFactory): Response
    {
        
        $table = $dataTableFactory->create()
            ->add('customer', 
                    TextColumn::class,   
                        [
                        'label' => 'Client',
                        'field' => 'c.name',
                        'globalSearchable' => true,
                        ])
            ->add('events', 
                    TextColumn::class, 
                        [
                        'label' => 'Lieux',
                        'field' => 'e.name'
                        ])
            ->add('date', 
                    DateTimeColumn::class, 
                        [
                        'label' => 'Date',
                        'format' => 'd-m-Y'
                        ])
            ->add('quantity', 
                    TextColumn::class,
                        [
                        'label' => 'Quantité',
                        ])
            ->add('total', 
                    TextColumn::class,
                        [
                        'label' => 'Total',
                        ])            
            ->add('action', 
                    TextColumn::class,
                        [
                        'label' => 'Action',
                        'render' => function($value, $context) {
                            $url = $this->generateUrl('invoice_view', array('invoice' => $context->getId()));
                            $url2 = $this->generateUrl('invoice_view', array('invoice' => $context->getId()));
                            return sprintf('<a href="%s">Voir</a> - <a href="%s">Modifier</a>', $url, $url2);
                            }
                        ])

            ->createAdapter(ORMAdapter::class, [
                'entity' => Invoices::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('i')
                        ->addSelect('e')
                        ->from(Invoices::class, 'i')
                        ->innerJoin('i.events', 'e')
                        ->innerJoin('i.customer','c')
                        ->andWhere('i.type=2')
                    ;
                },
            ])
            ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('orders.html.twig', [
           'datatable' => $table,
        ]);
    }

    #[Route('/orders/add', name: 'orders_add')]
    public function ordersAdd(Request $request): Response
    {
        $orders = new Invoices;
        $ordersForm = $this->createForm(
            OrdersFormType::class, 
            $orders, 
            [
                'action' => $this->generateUrl('orders_add'),
            ]
        );

        $ordersForm->handleRequest($request);
        if ($ordersForm->isSubmitted() && $ordersForm->isValid()) {

            $orders = $ordersForm->getData();
            // count total Invoces and total article
            $total= 0;
            $quantity = 0;
            foreach ($orders->getInvoiceLines() as $invoiceLine) {

                $total = $total + $invoiceLine->getPrice();
                $quantity = $quantity + $invoiceLine->getQuantity();
            }
            $orders->setTotal($total);
            $orders->setQuantity($quantity);

            $orders->setDate(new \DateTime("NOW"));
            $orders->setType(2);
            $this->em->persist($orders);
            $this->em->flush();
        }

        return $this->render('invoices/ordersAdd.html.twig', [
            'ordersForm' => $ordersForm->createView(),
        ]);
    }
}
