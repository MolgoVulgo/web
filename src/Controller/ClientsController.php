<?php

namespace App\Controller;

use App\Datatables\ClientsDatatable;
use App\Entity\Clients;
use App\Form\ClientFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sg\DatatablesBundle\Datatable\DatatableFactory;
use Sg\DatatablesBundle\Response\DatatableResponse;

class ClientsController extends AbstractController
{

    private $dtFactory;
    private $dtResponse;
    private $em;

    public function __construct(EntityManagerInterface $entityManager,DatatableFactory $datatableFactory, DatatableResponse $datatableResponse)
    {
        $this->dtFactory = $datatableFactory;
        $this->dtResponse = $datatableResponse;
        $this->em = $entityManager;
    }


    #[Route('/clients', name: 'clients')]
    public function clients(): Response
    {

        /** @var DatatableInterface $ClientsDatatable */
        $clientDatatable = $this->dtFactory->create(ClientsDatatable::class);
        $clientDatatable->buildDatatable();

        return $this->render('clients.html.twig', [
            'controller_name' => 'ClientsController',
            'clientDatatable' => $clientDatatable,
        ]);
    }

    #[Route('/clients/list', name: 'client_list')]
    public function clientsList(Request $request): Response
    {
        /** @var DatatableInterface $ClientsDatatable */
        $datatable = $this->dtFactory->create(ClientsDatatable::class);
        $datatable->buildDatatable();
        $responseService = $this->dtResponse;
        $responseService->setDatatable($datatable);
        $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
        $datatableQueryBuilder->getQb();
        return $responseService->getResponse();
    }


    #[Route('/clients/add', name: 'client_add')]
    public function clientsAdd(Request $request): Response
    {

        $client = new Clients;
        $clientForm = $this->createForm(ClientFormType::class, $client, ['action' => $this->generateUrl('client_add')]);

        $clientForm->handleRequest($request);
        if ($clientForm->isSubmitted() && $clientForm->isValid()) {

        }

        return $this->render('clients/add.html.twig', [
            'clientForm' => $clientForm->createView(),
        ]);
    }
}
