<?php

namespace App\Controller;

use App\Entity\Shop;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user/view', name: 'user_view')]
    public function view(EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shops = $shopRepo->findAll();

        return $this->render('user/user_profile.twig', [
            'shops' => $shops,
        ]);
    }

    #[Route('/user/favourites', name: 'user_favourites')]
    public function favourites(): Response
    {
        return $this->render('user/user_profile.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
