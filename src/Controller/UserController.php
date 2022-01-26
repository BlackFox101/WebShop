<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Shop;
use App\Entity\Status;
use App\Entity\User;
use App\Form\UserEditFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    #[Route('/user/view', name: 'user_view')]
    public function view(EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user)
        {
            return $this->redirectToRoute('app_login');
        }

        $shopRepo = $entityManager->getRepository(Shop::class);
        return $this->render('user/user_profile.twig', [
            'shops' => $shopRepo->findAll(),
        ]);
    }

    #[Route('/user/view/{userId}', name: 'user_view_by_id', requirements: ['shopId' => '\d+'])]
    public function viewById(int $userId, EntityManagerInterface $entityManager): Response
    {
        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->find($userId);
        if (!$user)
        {
            return $this->redirectToRoute('user_admin');
        }

        $shopRepo = $entityManager->getRepository(Shop::class);
        $shops = $shopRepo->findBy(['user' => $user->getUserId()]);

        return $this->render('user/user_profile_for_admin.html.twig', [
            'shops' => $shops,
            'user' => $user
        ]);
    }

    #[Route('/user/edit', name: 'user_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user  = $this->getUser();
        if (!$user)
        {
            return $this->redirectToRoute('app_registration');
        }

        $form = $this->createForm(UserEditFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('password')->getData())
            {
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
            }

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/edit.html.twig', [
            'userEditForm' => $form->createView()
        ]);
    }

    #[Route('/user/change_status', name: 'user_change_status', methods: "PUT")]
    public function changeStatus(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);
        $userRepo = $entityManager->getRepository(User::class);
        $statusRepo = $entityManager->getRepository(Status::class);

        $status = $statusRepo->find($parameters['id']);
        $user = $userRepo->find($parameters['userId']);
        $user->setStatus($status);

        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('OK');
    }

    #[Route('/user/favourites', name: 'user_favourites')]
    public function favourites(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $items = $user->getFavouriteItems();
        return $this->render('user/favorite_items.html.twig', [
            'favouriteItems' => $items
        ]);
    }

    #[Route('/user/admin', name: 'user_admin')]
    public function admin(EntityManagerInterface $entityManager): Response
    {
        $categoryRepo = $entityManager->getRepository(Category::class);
        $statusRepo = $entityManager->getRepository(Status::class);
        $userRepo = $entityManager->getRepository(User::class);

        $categories = $categoryRepo->findAll();
        $statuses = $statusRepo->findAll();
        $users = $userRepo->findAll();

        return $this->render('user/user_admin.twig', [
            'categories' => $categories,
            'statuses' => $statuses,
            'users' => $users
        ]);
    }

    #[Route('/user/favourites/change/{productId}', name: 'user_change_favourite', methods: "PUT")]
    public function changeFavouriteProduct(int $productId, EntityManagerInterface $entityManager): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user)
        {
            return $this->json('failed', 403);
        }

        $productRepo = $entityManager->getRepository(Product::class);
        $product = $productRepo->find($productId);
        if (!$product)
        {
            return $this->json('failed', 404);
        }

        if ($user->isProductInFavourites($product))
        {
            $user->removeFavouriteItem($product);
        }
        else
        {
            $user->addFavouriteItem($product);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json('success');
    }
}
