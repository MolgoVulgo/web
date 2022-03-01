<?php

namespace App\Controller;

use App\Entity\Fees;
use App\Entity\FeesType;
use App\Entity\Types;
use App\Form\FeesTypeFormType;
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

    #[Route('/setting/types', name: 'setting_products')]
    public function settingType(): Response
    {
     
        $types = $this->em->getRepository(Types::class)->findAll();
        return $this->render('settings/type.html.twig', [
            'types' => $types,
        ]);
    }

    #[Route('/setting/types/add', name: 'setting_products_add')]
    public function settingTypeAdd(Request $request): Response
    {
        $types = new Types;
        $typesForm = $this->createForm(
            TypesFormType::class, 
            $types, 
            [
                'action' => $this->generateUrl('setting_products_add'),
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

    #[Route('/setting/fees', name: 'setting_fees')]
    public function settingFees(): Response
    {
     
        $feesTypes = $this->em->getRepository(FeesType::class)->findAll();
        return $this->render('settings/fees.html.twig', [
            'feesTypes' => $feesTypes,
        ]);
    }

    #[Route('/setting/fees/add', name: 'setting_fees_add')]
    public function settingEventsAdd(Request $request): Response
    {
        $feesType = new FeesType;
        $feesTypeForm = $this->createForm(
            FeesTypeFormType::class, 
            $feesType, 
            [
                'action' => $this->generateUrl('setting_fees_add'),
            ]
        );

        $feesTypeForm->handleRequest($request);
        if ($feesTypeForm->isSubmitted() && $feesTypeForm->isValid()) {

            $feesType = $feesTypeForm->getData();
            $this->em->persist($feesType);
            $this->em->flush();

            if ($feesTypeForm->getClickedButton() === $feesTypeForm->get('enregistrerEtNouveau')){

                return $this->redirectToRoute('setting_fees_add', []);

            }else{

                return $this->redirectToRoute('setting_fees', []);
            }
            
        }

        return $this->render('settings/typeAdd.html.twig', [
            'feesTypeForm' => $feesTypeForm->createView(),
        ]);
    }
}

