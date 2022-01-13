<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\ShopFormType;
use App\Utils\CustomPaginator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ShopController extends AbstractController
{
    private const DEFAULT_PAGE_NUMBER = 1;
    private const PAGE_SIZE = 16;

    #[Route('/shops', name: 'shops')]
    public function getShops(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $page = (int)$request->get('page', self::DEFAULT_PAGE_NUMBER);
        if ($page < 0)
        {
            $page = 1;
        }
        else if ($page === 0)
        {
            $page = 1;
        }
        $name = $request->get('name');
        $paginator = $shopRepo->getShopPaginator(self::PAGE_SIZE, $page - 1, $name);
        return $this->render('pages/shop/shops.html.twig', [
            'paginator' => new CustomPaginator($paginator, self::PAGE_SIZE, $page)
        ]);
    }

    #[Route('/shop/{shopId}', name: 'shop', requirements: ['shopId' => '\d+'])]
    public function getShopById(int $shopId, EntityManagerInterface $entityManager, Security $security): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($shopId);
        if ($shop !== null) {
            return $this->render('pages/shop/shop.html.twig', [
                'shop'=> $shop
            ]);
        }

        return $this->redirectToRoute('shops');
    }

    #[Route('/shop/create', name: 'create_shop')]
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

    #[Route('shop/edit/{shopId}', name: 'edit_shop', requirements: ['shopId' => '\d+'])]
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
