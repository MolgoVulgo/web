<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Products;
use App\Form\ProductsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;

class ProductsController extends AbstractController
{

    private $em;
   
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    #[Route('/products', name: 'products')]
    public function index(Request $request, DataTableFactory $dataTableFactory): Response
    {

        $table = $dataTableFactory->create()
        ->add('ref', 
                TextColumn::class,   
                    [
                    'label' => 'Ref',
                    'globalSearchable' => true,
                    ])
        ->add('categoriesId', 
                TextColumn::class, 
                    [
                    'label' => 'Catégorie',
                    'field' => 'categories.name',
                    ])
        ->add('height', 
                TextColumn::class,
                    [
                    'label' => 'Taile',
                    ])
        ->add('gender', 
                TextColumn::class, 
                    [
                    'label' => 'Genre',
                    'render' => function($value, $context) {

                        if ($value == 'm'){
                            $genre = "Homme";
                        }else{
                            $genre = "Femme";
                        }
                        return sprintf('%s', $genre);
                    }
                    ])       
        ->add('action', 
                TextColumn::class,
                    [
                    'label' => 'Action',
                    'render' => function($value, $context) {
                        $url = $this->generateUrl('event_view', array('id' => $context->getId()));
                        $url2 = $this->generateUrl('event_view', array('id' => $context->getId()));
                        return sprintf('<a href="%s">Voir</a> - <a href="%s">Modifier</a>', $url, $url2);
                        }
                    ])

        ->createAdapter(ORMAdapter::class, [
            'entity' => Products::class,
        ])
        ->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getResponse();
        }

        return $this->render('products.html.twig', [
            'datatable' => $table,
        ]);

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
