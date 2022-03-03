<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Datatables\ProductsDatatable;
use App\Entity\Products;
use App\Form\ProductsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sg\DatatablesBundle\Datatable\DatatableFactory;
use Sg\DatatablesBundle\Response\DatatableResponse;

class ProductsController extends AbstractController
{

    private $dtFactory;
    private $dtResponse;
    
    public function __construct(EntityManagerInterface $entityManager,DatatableFactory $datatableFactory, DatatableResponse $datatableResponse)
    {
        $this->dtFactory = $datatableFactory;
        $this->dtResponse = $datatableResponse;
        $this->em = $entityManager;
    }

    #[Route('/products', name: 'products')]
    public function index(): Response
    {
        /** @var DatatableInterface $productsDatatable */
        $productsDatatable = $this->dtFactory->create(ProductsDatatable::class);
        $productsDatatable->buildDatatable();

        return $this->render('products.html.twig', [
            'productsDatatable' => $productsDatatable,
        ]);
    }

    #[Route('/products/list', name: 'products_list')]
    public function customersList(Request $request): Response
    {
        /** @var DatatableInterface $productsDatatable */
        $datatable = $this->dtFactory->create(ProductsDatatable::class);
        $datatable->buildDatatable();
        $responseService = $this->dtResponse;
        $responseService->setDatatable($datatable);
        $datatableQueryBuilder = $responseService->getDatatableQueryBuilder();
        $datatableQueryBuilder->getQb();
        return $responseService->getResponse();
    }

    #[Route('/products/add', name: 'products_add')]
    public function productsAdd(Request $request): Response
    {

        $products = new Products;
        $productsForm = $this->createForm(
            ProductsFormType::class, 
            $products, 
            [
                'action' => $this->generateUrl('products_add'),
            ]
        );

        $productsForm->handleRequest($request);
        if ($productsForm->isSubmitted() && $productsForm->isValid()) {

            $products = $productsForm->getData();
            $this->em->persist($products);
            $this->em->flush();
            
            if ($productsForm->getClickedButton() === $productsForm->get('saveAndNew')){
                return $this->redirectToRoute('products_add', []);
            }
            return $this->redirectToRoute('products', []);
        }

        return $this->render('products/productsAdd.html.twig', [
            'productsForm' => $productsForm->createView(),
        ]);
    }

}
