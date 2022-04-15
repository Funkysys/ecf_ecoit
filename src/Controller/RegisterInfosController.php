<?php

namespace App\Controller;

use App\Entity\Professor;
use App\Entity\Student;
use App\Entity\User;
use App\Form\BecomeProfessorType;
use App\Form\BecomeStudentType;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegisterInfosController extends AbstractController
{
    #[Route('/welcome', name: 'app_welcome')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        UserAuthenticatorInterface $userAuthenticator,
        AppCustomAuthenticator $authenticator
    ): Response
    {
        $user = $this->getUser();

        $user_profil = $user->getStudent();
        $form = $this->createForm(BecomeStudentType::class, $user_profil);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user_profil->setUser($user);
            $entityManager->persist($user_profil);
            $entityManager->flush();

            $this->redirectToRoute('app_home');
        }
        return $this->render('welcome/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
