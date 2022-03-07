<?php

namespace App\Controller;

use App\Entity\Invoices;
use App\Form\InvoicesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoicesController extends AbstractController
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    #[Route('/invoices', name: 'invoices')]
    public function invoices(): Response
    {
        $invoices = $this->em->getRepository(Invoices::class)->findAll();
        return $this->render('invoices.html.twig', [
            'invoices' => $invoices,
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
            $this->em->persist($invoices);
            $this->em->flush();
        }

        return $this->render('invoices/invoicesAdd.html.twig', [
            'invoicesForm' => $invoicesForm->createView(),
        ]);
    }
}
