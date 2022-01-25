<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Shop;
use App\Entity\Product;
use App\Form\ProductFormType;
use App\Services\Pagination\PaginationService;
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

    #[Route('/products', name: 'products')]
    public function getProducts(Request $request, EntityManagerInterface $entityManager): Response
    {
        $paginatorService = new PaginationService(Shop::class, $entityManager, $request);

        return $this->render('pages/product/list.html.twig', [
            'paginator' => $paginatorService->getPaginator(),
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

    #[Route('/products/create', name: '_create_shop_item', methods: "POST")]
    public function _createProduct(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);


        $shopRepo = $entityManager->getRepository(Shop::class);
        $categoryRepo = $entityManager->getRepository(Category::class);
        $shop = $shopRepo->find($parameters['shopId']);

        $Product = new Product($shop);
        $Product->setIsHidden(false);
        $Product->setCategory($categoryRepo->find($parameters['categoryId']));
        $Product->setDescription($parameters['description']);
        $Product->setName($parameters['title']);
        $Product->setPrice($parameters['price']);

        $entityManager->persist($Product);
        $entityManager->flush();

        return $this->redirectToRoute('shop', [
            'shopId' => $parameters['shopId']
        ]);
    }

    #[Route('/products/change_favorite', name: 'change_favorite', methods: "POST")]
    public function changeFavorite(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);
        $ProductRepo = $entityManager->getRepository(Product::class);

        $item = $ProductRepo->find($parameters['id']);
        // TODO
    }

    #[Route('/products/delete', name: 'delete_shop_item', methods: "DELETE")]
    public function deleteProduct(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);

        $ProductRepo = $entityManager->getRepository(Product::class);
        $Product = $ProductRepo->find($parameters['id']);

        $entityManager->remove($Product);
        $entityManager->flush();

        return new Response('Item has been deleted');
    }

    #[Route('/shop/{shopId}/product/create', name: 'create_shop_item', requirements: ['shopId' => '\d+'])]
    public function createProduct(Request $request, int $shopId, EntityManagerInterface $entityManager): Response
    {
        $shopRepo = $entityManager->getRepository(Shop::class);
        $categoryRepo = $entityManager->getRepository(Category::class);
        $shop = $shopRepo->find($shopId);
        $Product = new Product($shop);

        $form = $this->createForm(ProductFormType::class, $Product);
        $form->handleRequest($request);
        $response = $this->saveProduct($Product, $form, $entityManager);
        if ($response)
        {
            return $response;
        }

        return $this->render('pages/product/create.html.twig', [
            'ProductForm' => $form->createView(),
            'shopId' => $shopId,
            'categories' => $categoryRepo->findAll(),
        ]);
    }

    #[Route('/shop/item/{itemId}/edit', name: 'edit_shop_item', requirements: ['itemId' => '\d+'])]
    public function editProduct(Request $request, int $itemId, EntityManagerInterface $entityManager): Response
    {
        $productRepo = $entityManager->getRepository(Product::class);
        $product = $productRepo->find($itemId);

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);
        $response = $this->saveProduct($product, $form, $entityManager);
        if ($response)
        {
            return $response;
        }

        return $this->render('pages/product/edit.html.twig', [
            'ProductForm' => $form->createView()
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
