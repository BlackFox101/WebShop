<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Shop;
use App\Entity\Product;
use App\Entity\User;
use App\Form\ProductFormType;
use App\Services\Pagination\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products')]
    public function getProducts(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoryRepo = $entityManager->getRepository(Category::class);
        $paginatorService = new PaginationService(Product::class, $entityManager, $request);

        return $this->render('pages/product/list.html.twig', [
            'paginator' => $paginatorService->getPaginator(),
            'categories' => $categoryRepo->findAll(),
        ]);
    }

    #[Route('/products/{itemId}', name: 'shop_item', requirements: ['itemId' => '\d+'])]
    public function getProductById(int $itemId, EntityManagerInterface $entityManager): Response
    {
        $ProductRepo = $entityManager->getRepository(Product::class);
        $Product = $ProductRepo->find($itemId);

        return $this->render('pages/product/item.html.twig', [
            'Product' => $Product,
        ]);
    }

    #[Route('/product/delete/{productId}', name: 'delete_product', methods: "DELETE")]
    public function deleteProduct(int $productId,  Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user)
        {
            return $this->redirectToRoute('app_registration');
        }

        $productRepo = $entityManager->getRepository(Product::class);
        $product = $productRepo->find($productId);
        if (!$product)
        {
            return $this->json('failed', 404);
        }

        if (!$this->isGranted('ROLE_ADMIN', $user) && $product->getShop()->getUser()->getUserId() !== $user->getUserId())
        {
            return $this->json('failed', 403);
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->json('success deleted');
    }

    #[Route('/shop/{shopId}/product/create', name: 'create_shop_item', requirements: ['shopId' => '\d+'])]
    public function createProduct(Request $request, int $shopId, EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $shop = $shopRepo->find($shopId);
        $product = new Product($shop);

        $form = $this->createForm(ProductFormType::class, $product);
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
                $product->setImageName($newFilename);
            }

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('shop', ['shopId' => $shopId] );
        }

        return $this->render('pages/product/create.html.twig', [
            'productForm' => $form->createView(),
        ]);
    }

    #[Route('/product/edit{productId}', name: 'edit_shop_item', requirements: ['productId' => '\d+'])]
    public function editProduct(Request $request, int $productId, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user)
        {
            return $this->redirectToRoute('app_registration');
        }

        $productRepo = $entityManager->getRepository(Product::class);
        $product = $productRepo->find($productId);
        if (!$product)
        {
            return $this->json('failed', 404);
        }

        $form = $this->createForm(ProductFormType::class, $product);
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
                $product->setImageName($newFilename);
            }

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('shop', ['shopId' => $product->getShop()->getId()] );
        }

        return $this->render('pages/product/edit.html.twig', [
            'productForm' => $form->createView()
        ]);
    }

    private function saveProduct(Product $product, FormInterface $form, EntityManagerInterface $entityManager): ?Response
    {
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('shop_item', [
                'itemId' => $product->getProductId()
            ]);
        }

        return null;
    }
}
