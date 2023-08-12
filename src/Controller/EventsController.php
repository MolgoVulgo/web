<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventsFromType;
use Doctrine\ORM\EntityManagerInterface;
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
        ->add('fees', 
                TextColumn::class,
                    [
                    'label' => 'Frais',
                    ])
        ->add('invoiceCompute', 
                TextColumn::class,
                    [
                    'label' => 'Chiffres',
                    ])          
        ->add('ca', 
                TextColumn::class,
                    [
                    'label' => 'C.A',
                    ])            
        ->add('action', 
                TextColumn::class,
                    [
                    'label' => 'Action',
                    'render' => function($value, $context) {
                        $url = $this->generateUrl('event_view', array('id' => $context->getId()));
                        $url2 = $this->generateUrl('event_view', array('id' => $context->getId()));
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

    #[Route('/events/{id}/view', name: 'event_view')]
    public function eventView($id): Response
    {

        $event = $this->em->getRepository(Events::class)->find($id);
        $fees = $event->getFees();
        $invoices = $event->getInvoices();
        return $this->render('events/eventView.html.twig', [
            'event' => $event,
            'fees' => $fees,
            'invoices' => $invoices,
        ]);
    }
}
