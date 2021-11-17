<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ShopController extends AbstractController
{
    /**
     * @Route("/shops", name="app_shops")
     */
    public function shops(): Response
    {
        return $this->render('security/shops.html.twig', []);
    }
}
