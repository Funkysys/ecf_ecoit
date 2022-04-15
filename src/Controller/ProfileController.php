<?php

namespace App\Controller;

use App\Repository\ProfessorRepository;
use App\Repository\StudentRepository;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{

    #[Route('/my_profile', name: 'app_profile')]
    public function index(
        ProfessorRepository $professorRepository,
        StudentRepository $studentRepository): Response
    {
        $user = $this->getUser();
        $user_role = $user->getRoles();
        if ($user_role[0] === 'ROLE_PROFESSOR') {
            $user_id = $user->getProfessor()->getId();
            $repository = $professorRepository;
        } else if ($user_role[0] === 'ROLE_STUDENT') {
            $user_id = $user->getStudent()->getid();
            $repository = $studentRepository;
        } else {
            $this->redirectToRoute('app_home');
        }

        $user_infos = $repository->findOneById($user_id);
        return $this->render('professor_profile/index.html.twig', [
            'user_infos' => $user_infos,
        ]);
    }
}
