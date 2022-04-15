<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use App\Entity\Module;
use App\Entity\Professor;
use App\Entity\Section;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use function PHPUnit\Framework\throwException;

class ProfessorDashboardController extends AbstractDashboardController
{
    public $adminContextProvider;

    public function __construct(AdminContextProvider $adminContextProvider) {
        $this->adminContextProvider = $adminContextProvider;
    }
    #[IsGranted('ROLE_PROFESSOR')]
    #[Route('/professor', name: 'professor')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        $url = $adminUrlGenerator
                    ->setController(ProfessorCrudController::class)
                    ->generateUrl();
        return $this->redirect($url);

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        //return $this->render('admin/ProfessorDashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ECOIT')
            ;
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if (!$user instanceof User) {
            throw new \Exception('wrong user');
        }
        return parent::configureUserMenu($user)
            ->setMenuItems([
                MenuItem::linkToUrl('My Profile', 'fas fa-user', $this->generateUrl(
                    'app_professor_profile'
                ))
            ])
            ;

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Formation', 'fas fa-list', Formation::class);
        yield MenuItem::linkToCrud('Sections', 'fas fa-list', Section::class);
        yield MenuItem::linkToCrud('Modules', 'fas fa-list', Module::class);
        yield MenuItem::linkToCrud('Professor', 'fas fa-list', Professor::class);
    }

}
