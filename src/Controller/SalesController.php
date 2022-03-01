<?php

namespace App\Controller;

use App\Entity\Sales;
use App\Form\SalesFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalesController extends AbstractController
{
    #[Route('/sales', name: 'sales')]
    public function sales(): Response
    {
        return $this->render('sales.html.twig', []);
    }    
    
    #[Route('/sales/add', name: 'sales_add')]
    public function salesAdd(Request $request): Response
    {

        $sales = new Sales;
        $salesForm = $this->createForm(
            SalesFormType::class, 
            $sales, 
            [
                'action' => $this->generateUrl('sales_add'),
            ]
        );

        $salesForm->handleRequest($request);
        if ($salesForm->isSubmitted() && $salesForm->isValid()) {

            $sales = $salesForm->getData();
            $this->em->persist($sales);
            $this->em->flush();
        }

        return $this->render('sales/salesAdd.html.twig', [
            'salesForm' => $salesForm->createView(),
        ]);
    }
}
