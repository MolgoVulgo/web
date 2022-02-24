<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Datatables\ProduitsDatatable;
use App\Entity\Produits;
use App\Form\ProduitsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sg\DatatablesBundle\Datatable\DatatableFactory;
use Sg\DatatablesBundle\Response\DatatableResponse;

class ProduitsController extends AbstractController
{

    private $dtFactory;
    private $dtResponse;
    
    public function __construct(EntityManagerInterface $entityManager,DatatableFactory $datatableFactory, DatatableResponse $datatableResponse)
    {
        $this->dtFactory = $datatableFactory;
        $this->dtResponse = $datatableResponse;
        $this->em = $entityManager;
    }

    #[Route('/produits', name: 'produits')]
    public function index(): Response
    {
        /** @var DatatableInterface $produitsDatatable */
        $produitsDatatable = $this->dtFactory->create(ProduitsDatatable::class);
        $produitsDatatable->buildDatatable();

        return $this->render('produits.html.twig', [
            'produitsDatatable' => $produitsDatatable,
        ]);
    }

    #[Route('/produits/list', name: 'produits_list')]
    public function clientsList(Request $request): Response
    {
        /** @var DatatableInterface $produitsDatatable */
        $datatable = $this->dtFactory->create(ProduitsDatatable::class);
        $datatable->buildDatatable();
        $responseService = $this->dtResponse;
        $responseService->setDatatable($datatable);
        $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
        $datatableQueryBuilder->getQb();
        return $responseService->getResponse();
    }

    #[Route('/produits/add', name: 'produits_add')]
    public function produitsAdd(Request $request): Response
    {

        $produits = new Produits;
        $produitsForm = $this->createForm(
            ProduitsFormType::class, 
            $produits, 
            [
                'action' => $this->generateUrl('produits_add'),
            ]
        );

        $produitsForm->handleRequest($request);
        if ($produitsForm->isSubmitted() && $produitsForm->isValid()) {

            $client = $produitsForm->getData();
            $this->em->persist($client);
            $this->em->flush();
            
            // if ($clientForm->getClickedButton() === $clientForm->get('mensuration')){
            //     return $this->redirectToRoute('client_mensuration', [
            //         'client' => $client->getId(),
            //     ]);
            // }

        }

        return $this->render('produits/produitAdd.html.twig', [
            'produitsForm' => $produitsForm->createView(),
        ]);
    }

}
