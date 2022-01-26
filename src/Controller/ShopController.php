<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Shop;
use App\Form\ShopFormType;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ShopController extends AbstractController
{
    #[Route('/shops', name: 'shops')]
    public function getShops(Request $request, EntityManagerInterface $entityManager): Response
    {
        $paginatorService = new PaginationService(Shop::class, $entityManager, $request);

        return $this->render('pages/shop/list.html.twig', [
            'paginator' => $paginatorService->getPaginator(),
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

    #[Route('/shop/change_visibility', name: 'change_shop_visibility', methods: "POST")]
    public function changeShopVisibility(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $id = $parameters['id'];
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($id);
        $shop->setIsHidden(!$shop->getIsHidden());
        $entityManager->persist($shop);
        $entityManager->flush();
        return new Response('Visibility has been changed.');
    }

    #[Route('/shop/delete/{shopId}', name: 'delete_shop', requirements: ['shopId' => '\d+'], methods: "DELETE")]
    public function deleteShop(int $shopId, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($shopId);
        if ($user && $user->getUserId() === $shop->getUser()->getUserId())
        {
            $products = $shop->getProducts();
            foreach ($products as $product)
            {
                $product->setIsHidden(true);
                $product->setShop(null);
            }
            $entityManager->remove($shop);
            $entityManager->flush();

            return $this->json('Shop has been deleted');
        }
        return $this->json('failed', 403);
    }

    #[Route('/shop/change_name', name: 'change_shop_name', methods: "POST")]
    public function changeShopName(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);
        $shopRepo = $entityManager->getRepository(Shop::class);

        $shop = $shopRepo->find($parameters['shopId']);
        $shop->setName($parameters['name']);

        $entityManager->persist($shop);
        $entityManager->flush();

        return new Response('Shop name has been changed');
    }

    #[Route('/shop/change_description', name: 'change_shop_description', methods: "POST")]
    public function changeShopDescription(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);
        $shopRepo = $entityManager->getRepository(Shop::class);

        $shop = $shopRepo->find($parameters['shopId']);
        $shop->setDescription($parameters['description']);

        $entityManager->persist($shop);
        $entityManager->flush();

        return new Response('Shop description has been changed');
    }

    #[Route('/shop/create', name: 'create_shop')]
    public function createShop(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $shop = new Shop($user);

        $form = $this->createForm(ShopFormType::class, $shop);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $image = $form->get('image')->getData();
            if ($image)
            {
                $newFilename = uniqid() . '.'. $image->guessExtension();
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/images';
                $image->move(
                    $destination,
                    $newFilename
                );
                $shop->setImageName($newFilename);
            }

            $entityManager->persist($shop);
            $entityManager->flush();

            return $this->redirectToRoute('user_view');
        };

        return $this->render('pages/shop/create.html.twig', [
            'shopForm' => $form->createView()
        ]);
    }

    #[Route('shop/edit/{shopId}', name: 'edit_shop', requirements: ['shopId' => '\d+'])]
    public function editShop(Request $request, int $shopId, EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($shopId);
        $params = $request->request->all();
        $parameters = json_decode($request->getContent(), true);

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
