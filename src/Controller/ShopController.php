<?php

namespace App\Controller;

use App\Entity\Shop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ShopController extends AbstractController
{
    /**
     * @Route("/shops", name="app_shops")
     */
    public function index(Security $security): Response
    {
        $user = $security->getToken()->getUser();

        $shops = [
            new Shop(
                'Shop1',
                'https://files.sitepokupok.ru/stock/136249-3656f548.jpg',
            ),
            new Shop(
                'Shop2',
                'https://files.sitepokupok.ru/stock/136249-3656f548.jpg',
                'happieness',
                'Посуда Lefard - 8/21',
                'Красивая посуда и предметы интерьера'
            ),
            new Shop(
                'Shop3',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
            new Shop(
                'Shop1',
                'https://files.sitepokupok.ru/stock/136249-3656f548.jpg',
            ),
            new Shop(
                'Shop2',
                'https://files.sitepokupok.ru/stock/136249-3656f548.jpg',
                'happieness',
                'Посуда Lefard - 8/21',
                'Красивая посуда и предметы интерьера'
            ),
            new Shop(
                'Shop3',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
            new Shop(
                'Shop1',
                'https://files.sitepokupok.ru/stock/136249-3656f548.jpg',
            ),
            new Shop(
                'Shop2',
                'https://files.sitepokupok.ru/stock/136249-3656f548.jpg',
                'happieness',
                'Посуда Lefard - 8/21',
                'Красивая посуда и предметы интерьера'
            ),
            new Shop(
                'Shop3',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
        ];

        return $this->render('pages/shops.html.twig', [
            'shops'=> $shops,
            'user' => $user
        ]);
    }
}
