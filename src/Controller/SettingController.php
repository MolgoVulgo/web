<?php

namespace App\Controller;

use App\Entity\Frais;
use App\Entity\FraisType;
use App\Entity\Types;
use App\Form\FraisTypeFormType;
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

    #[Route('/setting/types', name: 'setting_produits')]
    public function settingType(): Response
    {
     
        $types = $this->em->getRepository(Types::class)->findAll();
        return $this->render('settings/type.html.twig', [
            'types' => $types,
        ]);
    }

    #[Route('/setting/types/add', name: 'setting_produits_add')]
    public function settingTypeAdd(Request $request): Response
    {
        $types = new Types;
        $typesForm = $this->createForm(
            TypesFormType::class, 
            $types, 
            [
                'action' => $this->generateUrl('setting_produits_add'),
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

    #[Route('/setting/frais', name: 'setting_frais')]
    public function settingFrais(): Response
    {
     
        $fraisTypes = $this->em->getRepository(FraisType::class)->findAll();
        return $this->render('settings/frais.html.twig', [
            'fraisTypes' => $fraisTypes,
        ]);
    }

    #[Route('/setting/frais/add', name: 'setting_frais_add')]
    public function settingEventsAdd(Request $request): Response
    {
        $fraisType = new FraisType;
        $fraisTypeForm = $this->createForm(
            FraisTypeFormType::class, 
            $fraisType, 
            [
                'action' => $this->generateUrl('setting_frais_add'),
            ]
        );

        $fraisTypeForm->handleRequest($request);
        if ($fraisTypeForm->isSubmitted() && $fraisTypeForm->isValid()) {

            $fraisType = $fraisTypeForm->getData();
            $this->em->persist($fraisType);
            $this->em->flush();

            if ($fraisTypeForm->getClickedButton() === $fraisTypeForm->get('enregistrerEtNouveau')){

                return $this->redirectToRoute('setting_frais_add', []);

            }else{

                return $this->redirectToRoute('setting_frais', []);
            }
            
        }

        return $this->render('settings/typeAdd.html.twig', [
            'fraisTypeForm' => $fraisTypeForm->createView(),
        ]);
    }
}

