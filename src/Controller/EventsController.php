<?php

namespace App\Controller;

use App\Entity\Evenements;
use App\Form\EventsFromType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    #[Route('/events', name: 'events')]
    public function events(): Response
    {
        return $this->render('events.html.twig', [

        ]);
    }

    #[Route('/events/add', name: 'event_add')]
    public function eventsAdd(Request $request): Response
    {

        $event = new Evenements;
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
            
            // if ($clientForm->getClickedButton() === $clientForm->get('mensuration')){
            //     return $this->redirectToRoute('client_mensuration', [
            //         'client' => $client->getId(),
            //     ]);
            // }

        }

        return $this->render('events/add.html.twig', [
            'eventForm' => $eventForm->createView(),
        ]);
    }
}
