<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Mensuration;
use App\Form\ClientFormType;
use App\Form\MensurationFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Datatables\ClientsDatatable;
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


    #[Route('/client/add', name: 'client_add')]
    public function clientAdd(Request $request): Response
    {

        $client = new Clients;
        $clientForm = $this->createForm(
            ClientFormType::class, 
            $client, 
            [
                'action' => $this->generateUrl('client_add'),
            ]
        );

        $clientForm->handleRequest($request);
        if ($clientForm->isSubmitted() && $clientForm->isValid()) {

            $client = $clientForm->getData();
            $this->em->persist($client);
            $this->em->flush();
            
            if ($clientForm->getClickedButton() === $clientForm->get('mensuration')){
                return $this->redirectToRoute('client_mensuration', [
                    'client' => $client->getId(),
                ]);
            }

        }

        return $this->render('clients/clientAdd.html.twig', [
            'clientForm' => $clientForm->createView(),
        ]);
    }

    #[Route('/client/{client}/edit', name: 'client_edit')]
    public function clientEdit(Request $request, Clients $client) : Response
    {

        $client = $this->em->getRepository(clients::class)->find($client);
        $clientForm = $this->createForm(
            ClientFormType::class, 
            $client, 
            [
                'action' => $this->generateUrl('client_edit',['client' => $client->getId()]),
            ]
        );

        $clientForm->handleRequest($request);
        if ($clientForm->isSubmitted() && $clientForm->isValid()) {

            $client = $clientForm->getData();
            $this->em->persist($client);
            $this->em->flush();

            if ($clientForm->getClickedButton() === $clientForm->get('mensuration')){
                return $this->redirectToRoute('client_mensuration', [
                    'client' => $client->getId(),
                ]);
            }

            return $this->redirectToRoute('clients');
        }

        return $this->render('clients/clientAdd.html.twig', [
            'clientForm' => $clientForm->createView(),
        ]);
    }



    #[Route('/clients/{client}/mensuration', name: 'client_mensuration')]
    public function clientMensuration(Request $request,Clients $client): Response
    {
        
        $mensuration = $client->getMensuration();
        if (is_null($mensuration)) {
            $mensuration = new Mensuration;
        }
            
        $mensurationForm = $this->createForm(
            MensurationFormType::class, 
            $mensuration, 
            [
                'action' => $this->generateUrl('client_mensuration',['client' => $client->getId()]),
                'genre' => $client->getGenre(),
            ]
        );

        $mensurationForm->handleRequest($request);
        if ($mensurationForm->isSubmitted() && $mensurationForm->isValid()) {

            $mensuration = $mensurationForm->getData();
            $client->setMensuration($mensuration);
            $this->em->persist($client);
            $this->em->flush();

        }

        return $this->render('clients/mensuration.html.twig', [
            'mensurationForm' => $mensurationForm->createView(),
            'genre' => $client->getGenre(),
        ]);
    }

}
