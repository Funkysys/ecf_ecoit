<?php

namespace App\Controller;

use App\Entity\Professor;
use App\Form\BecomeProfessorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BecomeProfessorController extends AbstractController
{
    #[Route('/become/professor', name: 'app_become_professor')]
    public function index(Request $request,EntityManagerInterface $entityManager): Response
    {
        $professor = new Professor();
        $form = $this->createForm(BecomeProfessorType::class, $professor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($professor);
                $entityManager->flush();

                return $this->redirectToRoute('app_waiting_professor');
            }

        return $this->render('become_professor/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
