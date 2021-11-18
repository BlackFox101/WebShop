<?php

namespace App\Controller;

use App\Entity\Status;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setFirstName($request->get('firstName'));
            $user->setLastName($request->get('lastName'));
            $user->setLogin($request->get('login'));
            $user->setPhone($request->get('phone'));

            $statusRepo = $entityManager->getRepository(Status::class);
            $user->setStatus($statusRepo->findOneBy(['name' => 'COMMON']));

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('pages/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
