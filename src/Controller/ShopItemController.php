<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Entity\ShopItem;
use App\Form\ShopItemFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopItemController extends AbstractController
{
    #[Route('/shop/item', name: 'shop_items')]
    public function getShopItems(EntityManagerInterface $entityManager): Response
    {
        $shopItemRepo = $entityManager->getRepository(ShopItem::class);
        $shopItems = $shopItemRepo->findAll();

        return $this->render('pages/shop_item/items.html.twig', [
            'shopItems' => $shopItems,
        ]);
    }

    #[Route('/shop/item/{itemId}', name: 'shop_item', requirements: ['itemId' => '\d+'])]
    public function getShopItemById(int $itemId, EntityManagerInterface $entityManager): Response
    {
        $shopItemRepo = $entityManager->getRepository(ShopItem::class);
        $shopItem = $shopItemRepo->find($itemId);

        return $this->render('pages/shop_item/item.html.twig', [
            'shopItem' => $shopItem,
        ]);
    }

    #[Route('/shop/{shopId}/item/create', name: 'create_shop_item', requirements: ['shopId' => '\d+'])]
    public function createShopItem(Request $request, int $shopId, EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($shopId);
        $shopItem = new ShopItem($shop);

        $form = $this->createForm(ShopItemFormType::class, $shopItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($shopItem);
            $entityManager->flush();

            return $this->redirectToRoute('shop_item', [
                'shopId' => $shopId
            ]);
        }

        return $this->render('pages/shop_item/create.html.twig', [
            'shopItemForm' => $form->createView(),
        ]);
    }

    #[Route('/shop/{shopId}/item', name: 'get_shop_items', requirements: ['shopId' => '\d+'])]
    public function getShopItemsByShopId(int $shopId, EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($shopId);

        return $this->render('pages/shop_item/items.html.twig', [
            'shopItems' => $shop->getShopItems(),
        ]);
    }
}
