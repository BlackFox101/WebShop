<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Shop;
use App\Entity\ShopItem;
use App\Form\ShopItemFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private const DEFAULT_PAGE_NUMBER = 1;
    private const PAGE_SIZE = 4;

    #[Route('/products', name: 'shop_items')]
    public function getProducts(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shopItemRepo = $entityManager->getRepository(ShopItem::class);
        $page = (int)$request->get('page', self::DEFAULT_PAGE_NUMBER);

        return $this->render('pages/product/list.html.twig', [
            'shopItems' => $shopItems,
        ]);
    }

    #[Route('/products/{itemId}', name: 'shop_item', requirements: ['itemId' => '\d+'])]
    public function getShopItemById(int $itemId, EntityManagerInterface $entityManager): Response
    {
        $shopItemRepo = $entityManager->getRepository(ShopItem::class);
        $shopItem = $shopItemRepo->find($itemId);

        return $this->render('pages/product/item.html.twig', [
            'shopItem' => $shopItem,
        ]);
    }

    #[Route('/products/create', name: '_create_shop_item', methods: "POST")]
    public function _createShopItem(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($parameters['shopId']);

        $category = new Category();
        $category->setName($parameters['category']);

        $shopItem = new ShopItem($shop);
        $shopItem->setIsHidden(false);
        $shopItem->setCategory($category);
        $shopItem->setDescription($parameters['description']);
        $shopItem->setName($parameters['title']);
        $shopItem->setPrice($parameters['price']);

        $entityManager->persist($category);
        $entityManager->persist($shopItem);
        $entityManager->flush();

        return new Response($parameters['title']);
    }

    #[Route('/shop/{shopId}/product/create', name: 'create_shop_item', requirements: ['shopId' => '\d+'])]
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

        return $this->render('pages/product/create.html.twig', [
            'shopItemForm' => $form->createView(),
            'shopId' => $shopId,
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

        return $this->render('pages/product/edit.html.twig', [
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
