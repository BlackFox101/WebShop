<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ShopController extends AbstractController
{
    #[Route('/shop', name: 'shops')]
    public function getShops(EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shops = $shopRepo->findAll();

        return $this->render('pages/shop/shops.html.twig', [
            'shops'=> $shops
        ]);
    }

    #[Route('/shop/{shopId}', name: 'shop', requirements: ['shopId' => '\d+'])]
    public function getShopById(int $shopId, EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($shopId);

        return $this->render('pages/shop/shop.html.twig', [
            'shop'=> $shop
        ]);
    }

    #[Route('/shop/create', name: 'create_shop')]
    public function createShop(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getToken()->getUser();
        $shop = new Shop($user);
        $form = $this->createForm(ShopFormType::class, $shop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($shop);
            $entityManager->flush();

            return $this->redirectToRoute('shop');
        }

        return $this->render('pages/shop/create-shop.html.twig', [
            'shopForm' => $form->createView(),
        ]);
    }
}
