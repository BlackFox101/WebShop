<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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
    public function favourites(Security $security): Response
    {
        $user = $security->getToken()->getUser();
        $items = $user->getFavouriteItems();
        return $this->render('user/user_profile.twig', [
            'controller_name' => 'UserController',
            'favouriteItems' => $items
        ]);
    }

    #[Route('/user/admin', name: 'user_admin')]
    public function admin(Security $security): Response
    {
        $user = $security->getToken()->getUser();
        $items = $user->getFavouriteItems();
        return $this->render('user/user_admin.twig', [
            'controller_name' => 'UserController',
            'favouriteItems' => $items
        ]);
    }
}
