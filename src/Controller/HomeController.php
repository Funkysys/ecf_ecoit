<?php

namespace App\Controller;

use App\Repository\ProfessorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProfessorRepository $professorRepository): Response
    {
        $professors = $professorRepository->findAll();

        foreach ($professors as $professor) {

            dd($professor->getUser()->getEmail());
        }
        return $this->render('home/index.html.twig', [

        ]);
    }
}
