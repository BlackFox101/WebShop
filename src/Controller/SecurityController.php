<?php

namespace App\Controller;

use App\Entity\Shop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

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

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
