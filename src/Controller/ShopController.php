<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ShopController extends AbstractController
{
    #[Route('/shops', name: 'shops')]
    public function getShops(EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shops = $shopRepo->findAll();

        return $this->render('pages/shop/shops.html.twig', [
            'shops'=> $shops
        ]);
    }

    #[Route('/shop/{shopId}', name: 'shop', requirements: ['shopId' => '\d+'])]
    public function getShopById(int $shopId, EntityManagerInterface $entityManager, Security $security): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($shopId);

        $user = $security->getToken()->getUser();
        $items = $user->getFavouriteItems();

        if ($shop !== null) {
            return $this->render('pages/shop/shop.html.twig', [
                // TODO: isLikedMe
                'favouriteItemIds' => $items,
                'shop'=> $shop
            ]);
        }

        return $this->redirectToRoute('shops');
    }

    #[Route('/shops/create', name: 'create_shop')]
    public function createShop(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getToken()->getUser();
        $shop = new Shop($user);
        $form = $this->createForm(ShopFormType::class, $shop);
        $form->handleRequest($request);

        $response = $this->saveShop($shop, $form, $entityManager);
        if ($response)
        {
            return $response;
        }

        return $this->render('pages/shop/create.html.twig', [
            'shopForm' => $form->createView(),
        ]);
    }

    #[Route('shops/{shopId}/edit', name: 'edit_shop', requirements: ['shopId' => '\d+'])]
    public function editShop(Request $request, int $shopId, EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($shopId);

//        $form = $this->createForm(ShopFormType::class, $shop);
//        $form->handleRequest($request);

//        $response = $this->saveShop($shop, $form, $entityManager);
//        if ($response)
//        {
//            return $response;
//        }

        return $this->render('pages/shop/edit.html.twig', [
            'shop' => $shop,
        ]);
    }

    private function saveShop(Shop $shop, FormInterface $form, EntityManagerInterface $entityManager): ?Response
    {
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($shop);
            $entityManager->flush();

            return $this->redirectToRoute('shop', [
                'shopId' => $shop->getId(),
            ]);
        }

        return null;
    }
}
