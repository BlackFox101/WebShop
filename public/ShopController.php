<?php

namespace App\Controller;

use App\Entity\Shop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ShopController extends AbstractController
{
    /**
     * @Route("/shops", name="app_shops")
     */
    public function shops(AuthenticationUtils $authenticationUtils): Response
    {
        $shops = [
            new Shop(
                'https://files.sitepokupok.ru/stock/136625-bf67c7ad.jpg',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
            new Shop(
                'https://files.sitepokupok.ru/stock/136249-3656f548.jpg',
                'https://files.sitepokupok.ru/user/621-ce176e1f.jpg',
                'happieness',
                'Посуда Lefard - 8/21',
                'Красивая посуда и предметы интерьера'
            ),
            new Shop(
                'https://files.sitepokupok.ru/stock/136625-bf67c7ad.jpg',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
            new Shop(
                'https://files.sitepokupok.ru/stock/136625-bf67c7ad.jpg',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
            new Shop(
                'https://files.sitepokupok.ru/stock/136625-bf67c7ad.jpg',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
            new Shop(
                'https://files.sitepokupok.ru/stock/136625-bf67c7ad.jpg',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
            new Shop(
                'https://files.sitepokupok.ru/stock/136625-bf67c7ad.jpg',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
            new Shop(
                'https://files.sitepokupok.ru/stock/136625-bf67c7ad.jpg',
                'https://files.sitepokupok.ru/user/155636927-5e687aa0.jpg',
                'SuperKachok',
                'Семена овощей!',
                'Ассортимент овощей-помидоры, огурцы и многое другое!'
            ),
        ];

        return $this->render('security/shops.html.twig', [
            'shops'=> $shops,
        ]);

        if ($this->getUser()) {
            return $this->render('security/shops.html.twig', []);
        }

        return $this->redirect('/login');
    }
}
