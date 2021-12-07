<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Entity\ShopItem;
use App\Form\ShopItemFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $response = $this->saveShopItem($shopItem, $form, $entityManager);
        if ($response)
        {
            return $response;
        }

        return $this->render('pages/shop_item/create.html.twig', [
            'shopItemForm' => $form->createView(),
        ]);
    }

    #[Route('/shop/item/{itemId}/edit', name: 'edit_shop_item', requirements: ['itemId' => '\d+'])]
    public function editShopItem(Request $request, int $itemId, EntityManagerInterface $entityManager): Response
    {
        $shopItemRepo = $entityManager->getRepository(ShopItem::class);
        $shopItem = $shopItemRepo->find($itemId);

        $form = $this->createForm(ShopItemFormType::class, $shopItem);
        $form->handleRequest($request);
        $response = $this->saveShopItem($shopItem, $form, $entityManager);
        if ($response)
        {
            return $response;
        }

        return $this->render('pages/shop_item/edit.html.twig', [
            'shopItemForm' => $form->createView()
        ]);
    }

    private function saveShopItem(ShopItem $shopItem, FormInterface $form, EntityManagerInterface $entityManager): ?Response
    {
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($shopItem);
            $entityManager->flush();

            return $this->redirectToRoute('shop_item', [
                'itemId' => $shopItem->getId()
            ]);
        }

        return null;
    }
}
