<?php

namespace App\Controller;

use App\Form\BecomeProfessorType;
use App\Form\BecomeStudentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateProfessorInfosController extends AbstractController
{
    #[Route('/infos', name: 'app_update_profile')]
    public function index(
        EntityManagerInterface $entityManager,
        Request $request,
        ): Response
    {
        $user = $this->getUser();

        if ($user->getRoles() === ["ROLE_PROFESSOR"]) {
            $user_profil = $user->getProfessor();
            $form = $this->createForm(BecomeProfessorType::class, $user_profil);
        } else if ($user->getRoles() === ["ROLE_STUDENT"]) {
            $user_profil = $user->getStudent();
            $form = $this->createForm(BecomeStudentType::class, $user_profil);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user_profil->setUser($user);
            $entityManager->persist($user_profil);
            $entityManager->flush();

            $this->redirectToRoute('app_home');
        }

        return $this->render('update_infos/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
