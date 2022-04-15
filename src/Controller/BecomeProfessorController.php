<?php

namespace App\Controller;

use App\Entity\Professor;
use App\Form\BecomeProfessorType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BecomeProfessorController extends AbstractController
{
    #[Route('/welcome_professor', name: 'app_welcome_professor')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        AdminContextProvider $adminContextProvider,
        UserRepository $userRepository,
    ): Response
    {

        $user = $this->getUser();
        $professor = new Professor();
        $form = $this->createForm(BecomeProfessorType::class, $professor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $professor->setUser($user);
                $entityManager->persist($professor);
                $entityManager->flush();

                return $this->redirectToRoute('app_waiting_professor');
            }

        return $this->render('welcome/professor.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
