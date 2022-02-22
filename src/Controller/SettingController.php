<?php

namespace App\Controller;

use App\Entity\Types;
use App\Form\TypesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingController extends AbstractController
{    

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }


    #[Route('/settings', name: 'settings')]
    public function setting(): Response
    {
        return $this->render('settings.html.twig', [
        ]);
    }

    #[Route('/setting/types', name: 'setting_types')]
    public function settingType(): Response
    {
     
        $types = $this->em->getRepository(Types::class)->findAll();
        return $this->render('settings/type.html.twig', [
            'types' => $types,
        ]);
    }

    #[Route('/setting/types/add', name: 'setting_types_add')]
    public function settingTypeAdd(Request $request): Response
    {
        $types = new Types;
        $typesForm = $this->createForm(
            TypesFormType::class, 
            $types, 
            [
                'action' => $this->generateUrl('setting_types_add'),
            ]
        );

        $typesForm->handleRequest($request);
        if ($typesForm->isSubmitted() && $typesForm->isValid()) {

            $types = $typesForm->getData();
            $this->em->persist($types);
            $this->em->flush();
            
        }
        return $this->render('settings/typeAdd.html.twig', [
            'typesForm' => $typesForm->createView(),
        ]);
    }

    #[Route('/setting/events', name: 'setting_events')]
    public function settingEvents(): Response
    {
     
        $types = $this->em->getRepository(Types::class)->findAll();
        return $this->render('settings/events.html.twig', [
            'types' => $types,
        ]);
    }

    #[Route('/setting/events/add', name: 'setting_events_add')]
    public function settingEventsAdd(): Response
    {
     
        $types = $this->em->getRepository(Types::class)->findAll();
        return $this->render('settings/events.html.twig', [
            'types' => $types,
        ]);
    }
}

