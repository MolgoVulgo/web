<?php

namespace App\Controller;

use App\Entity\Ventes;
use App\Form\VentesFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VentesController extends AbstractController
{
    #[Route('/ventes', name: 'ventes')]
    public function ventes(): Response
    {
        return $this->render('ventes.html.twig', []);
    }    
    
    #[Route('/vente/add', name: 'vente_add')]
    public function ventesAdd(Request $request): Response
    {

        $vente = new Ventes;
        $venteForm = $this->createForm(
            VentesFormType::class, 
            $vente, 
            [
                'action' => $this->generateUrl('vente_add'),
            ]
        );

        $venteForm->handleRequest($request);
        if ($venteForm->isSubmitted() && $venteForm->isValid()) {

            $vente = $venteForm->getData();
            $this->em->persist($vente);
            $this->em->flush();
        }

        return $this->render('ventes/venteAdd.html.twig', [
            'venteForm' => $venteForm->createView(),
        ]);
    }
}
