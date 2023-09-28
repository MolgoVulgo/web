<?php

namespace App\Controller;

use App\Entity\Events;
use App\Entity\Fees;
use App\Entity\Invoices;
use App\Form\EventsFromType;
use App\Form\FeesFormType;
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

class EventsController extends AbstractController
{
    private $em;
    private $eventId;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    #[Route('/events', name: 'events')]
    public function events(Request $request, DataTableFactory $dataTableFactory): Response
    {

        $table = $dataTableFactory->create()
            ->add('name', 
                    TextColumn::class,   
                        [
                        'label' => 'Event',
                        'globalSearchable' => true,
                        ])
            ->add('location', 
                    TextColumn::class, 
                        [
                        'label' => 'Lieux',
                        ])
            ->add('startDate', 
                    DateTimeColumn::class, 
                        [
                        'label' => 'Date',
                        'format' => 'd-m-Y'
                        ])
            ->add('invoiceCompute', 
                    TextColumn::class,
                        [
                        'label' => 'Chiffres',
                        'render' => function($value, $context) {

                                $compute = 0;
                                foreach ($context->getInvoices() as $invoice) {
                                    $compute = $compute + $invoice->getTotal();
                                }
                                return sprintf('%s', $compute);
                            }
                        ])       
            ->add('fees', 
                    TextColumn::class,
                        [
                        'label' => 'Frais',
                        'render' => function($value, $context) {

                            $totalFees = 0;
                            foreach ($context->getFees() as $fee) {
                                $totalFees = $totalFees + $fee->getPrice();
                            }
                            return sprintf('%s', $totalFees);
                        }
                        ])               
            ->add('ca', 
                    TextColumn::class,
                        [
                        'label' => 'C.A',
                        'render' => function($value, $context) {

                            $compute = 0;
                            $totalFees = 0;
                            foreach ($context->getFees() as $fee) {
                                $totalFees = $totalFees + $fee->getPrice();
                            }
                            foreach ($context->getInvoices() as $invoice) {
                                $compute = $compute + $invoice->getTotal();
                            }
                            return sprintf('%s', $compute-$totalFees);
                        }
                        ])            
            ->add('action', 
                TextColumn::class,
                    [
                    'label' => 'Action',
                    'render' => function($value, $context) {
                        $url = $this->generateUrl('event_view', array('eventId' => $context->getId()));
                        $url2 = $this->generateUrl('event_edit', array('event' => $context->getId()));
                        return sprintf('<a href="%s">Voir</a> - <a href="%s">Modifier</a>', $url, $url2);
                        }
                    ])

        ->createAdapter(ORMAdapter::class, [
            'entity' => Events::class,
        ])
        ->handleRequest($request);

    if ($table->isCallback()) {
        return $table->getResponse();
    }

        return $this->render('events.html.twig', [
            'datatable' => $table,
        ]);
    }

    #[Route('/events/add', name: 'event_add')]
    public function eventsAdd(Request $request): Response
    {

        $event = new Events;
        $eventForm = $this->createForm(
            EventsFromType::class, 
            $event, 
            [
                'action' => $this->generateUrl('event_add'),
            ]   
        );

        $eventForm->handleRequest($request);
        if ($eventForm->isSubmitted() && $eventForm->isValid()) {

            $event = $eventForm->getData();
            $this->em->persist($event);
            $this->em->flush();
            
            return $this->redirectToRoute('events', []);

        }

        return $this->render('events/eventAdd.html.twig', [
            'eventForm' => $eventForm->createView(),
        ]);
    }

    #[Route('/events/{event}/edit', name: 'event_edit')]
    public function eventsModify(Request $request, events $event): Response
    {

        //dd($event);

        //$event = $this->em->getRepository(events::class)->find();
        $eventForm = $this->createForm(
            EventsFromType::class, 
            $event, 
            [
                'action' => $this->generateUrl('event_edit',['event' => $event->getId()]),
            ]   
        );

        $eventForm->handleRequest($request);
        if ($eventForm->isSubmitted() && $eventForm->isValid()) {

            $event = $eventForm->getData();
            
                foreach ($event->getFees() as $fee) {

                    if (!($fee->getEvents()))
                        $fee->setEvents($event);
                }
                
            $this->em->persist($event);
            $this->em->flush();
            
            return $this->redirectToRoute('events', []);

        }

        return $this->render('events/eventAdd.html.twig', [
            'eventForm' => $eventForm->createView(),
        ]);
    }


    #[Route('/events/{eventId}/view', name: 'event_view')]
    public function eventView($eventId,Request $request, DataTableFactory $dataTableFactory): Response
    {
        $this->eventId= $eventId;

        $tableInvoices = $dataTableFactory->create()
            ->setName('tableInvoices')
            ->add('customer', 
                    TextColumn::class,   
                        [
                        'label' => 'Client',
                        'field' => 'c.name',
                        'globalSearchable' => true,
                        ])
            ->add('date', 
                    DateTimeColumn::class, 
                        [
                        'label' => 'Date',
                        'format' => 'd-m-Y'
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
                        ->andWhere('e.id= :eventId')
                        ->setParameter('eventId', $this->eventId);
                },
            ])
            ->handleRequest($request);

        
            
        $tableFees = $dataTableFactory->create()
            ->setName('tableFees')
            ->add('typeId', 
                    TextColumn::class,   
                        [
                        'label' => 'Type',
                        'field' => 't.name',
                        'globalSearchable' => true,
                        ])
            ->add('price', 
                    TextColumn::class,
                        [
                        'label' => 'Total',
                        ])            
            // ->add('action', 
            //         TextColumn::class,
            //             [
            //             'label' => 'Action',
            //             'render' => function($value, $context) {
            //                 $url = $this->generateUrl('invoice_view', array('invoice' => $context->getId()));
            //                 $url2 = $this->generateUrl('invoice_view', array('invoice' => $context->getId()));
            //                 return sprintf('<a href="%s">Voir</a> - <a href="%s">Modifier</a>', $url, $url2);
            //                 }
            //             ])

            ->createAdapter(ORMAdapter::class, [
                'entity' => Fees::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('f')
                        ->addSelect('t')
                        ->from(Fees::class, 'f')
                        ->innerJoin('f.type','t')
                        ->andWhere('f.type=t.id')
                        ->andWhere('f.events= :eventId')
                        ->setParameter('eventId', $this->eventId)
                        ;
                },
            ])
            ->handleRequest($request);

        if ($tableFees->isCallback()) {
                return $tableFees->getResponse();
            }
        
        if ($tableInvoices->isCallback()) {
            return $tableInvoices->getResponse();
        }

        $event = $this->em->getRepository(Events::class)->find($eventId);
        $fees = $event->getFees();
        $invoices = $event->getInvoices();
        return $this->render('events/eventView.html.twig', [
            'tableInvoices' => $tableInvoices,
            'tableFees' => $tableFees,
            'event' => $event,
            'fees' => $fees,
        ]);
    }

    #[Route('/events/{eventId}/add/fees', name: 'event_add_fees')]
    public function eventsAddFees($eventId, Request $request): Response
    {
        $fees = new Fees;
        $feesForm = $this->createForm(
            FeesFormType::class, 
            $fees, 
            [
                'action' => $this->generateUrl('event_add_fees',['eventId' => $eventId]),
            ]
        );

        $feesForm->handleRequest($request);
        if ($feesForm->isSubmitted() && $feesForm->isValid()) {

            $event = $feesForm->getData();
            $this->em->persist($event);
            $this->em->flush();
            
            return $this->redirectToRoute('events', []);

        }

        return $this->render('events/eventFeesAdd.html.twig', [
            'feesForm' => $feesForm->createView(),
        ]);

    }
}
