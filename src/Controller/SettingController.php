<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SettingController extends AbstractController
{    
    #[Route('/setting', name: 'setting_type')]
    public function settingType(): Response
    {
        return $this->render('settings/type.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
