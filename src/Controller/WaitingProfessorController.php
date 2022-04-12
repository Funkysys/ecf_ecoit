<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WaitingProfessorController extends AbstractController
{
    #[Route('/waiting/professor', name: 'app_waiting_professor')]
    public function index(): Response
    {
        return $this->render('waiting_professor/index.html.twig', [
            'controller_name' => 'WaitingProfessorController',
        ]);
    }
}
