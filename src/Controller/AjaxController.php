<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

   
    #[Route('/ajax/get/product/{id}', name: 'ajax_get_product')]
    public function ajaxGetProduct($id): Response
    {
        
        $product = $this->em->getRepository(Products::class)->getProduct($id);
        return new JsonResponse($product);
    }
}
