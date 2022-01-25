<?php


namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category/delete', name: 'delete_Category', methods: "DELETE")]
    public function deleteCategory(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);
        $categoryRepo = $entityManager->getRepository(Category::class);

        $category = $categoryRepo->find($parameters['id']);

        $entityManager->remove($category);
        $entityManager->flush();

        return new Response('Category has been deleted');
    }

    #[Route('/category/create', name: 'create_Category', methods: "POST")]
    public function createCategory(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);

        $category = new Category();
        $category->setName($parameters['name']);

        $entityManager->persist($category);
        $entityManager->flush();

        return new Response($category->getId());
    }
}