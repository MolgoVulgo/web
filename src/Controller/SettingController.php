<?php

namespace App\Controller;

use App\Entity\Fees;
use App\Entity\FeesType;
use App\Entity\Categories;
use App\Form\FeesTypeFormType;
use App\Form\CategoriesFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingController extends AbstractController
{    
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    // General //
    #[Route('/settings', name: 'settings')]
    public function setting(): Response
    {
        return $this->render('settings.html.twig', [
        ]);
    }

    #[Route('/setting/category', name: 'setting_categories')]
    public function settingType(): Response
    {
     
        $categories = $this->em->getRepository(Categories::class)->findAll();
        return $this->render('settings/category.html.twig', [
            'categories' => $categories,
        ]);
    }

    // category products //
    #[Route('/setting/category/add', name: 'setting_category_add')]
    public function settingCategoryAdd(Request $request): Response
    {
        $categories = new Categories;
        $categoriesForm = $this->createForm(
            CategoriesFormType::class, 
            $categories, 
            [
                'action' => $this->generateUrl('setting_category_add'),
            ]
        );

        $categoriesForm->handleRequest($request);
        if ($categoriesForm->isSubmitted() && $categoriesForm->isValid()) {

            $categories = $categoriesForm->getData();
            $this->em->persist($categories);
            $this->em->flush();

            if ($categoriesForm->getClickedButton() === $categoriesForm->get('saveAndNew')){
                return $this->redirectToRoute('setting_category_add', []);
            }

            return $this->redirectToRoute('setting_categories', []);

            return $this->redirectToRoute('customers', []);
            
        }
        return $this->render('settings/categoryAdd.html.twig', [
            'categoriesForm' => $categoriesForm->createView(),
        ]);
    }

    // fees //
    #[Route('/setting/fees', name: 'setting_fees')]
    public function settingFees(): Response
    {
     
        $fees = $this->em->getRepository(FeesType::class)->findAll();
        return $this->render('settings/fees.html.twig', [
            'fees' => $fees,
        ]);
    }

    #[Route('/setting/fees/add', name: 'setting_fees_add')]
    public function settingEventsAdd(Request $request): Response
    {
        $fees = new FeesType;
        $feesForm = $this->createForm(
            FeesTypeFormType::class, 
            $fees, 
            [
                'action' => $this->generateUrl('setting_fees_add'),
            ]
        );

        $feesForm->handleRequest($request);
        if ($feesForm->isSubmitted() && $feesForm->isValid()) {

            $fees = $feesForm->getData();
            $this->em->persist($fees);
            $this->em->flush();

            if ($feesForm->getClickedButton() === $feesForm->get('saveAndNew')){

                return $this->redirectToRoute('setting_fees_add', []);

            }else{

                return $this->redirectToRoute('setting_fees', []);
            }
            
        }

        return $this->render('settings/feesAdd.html.twig', [
            'feesForm' => $feesForm->createView(),
        ]);
    }
}

