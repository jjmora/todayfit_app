<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {
        /** @var User $user */
        $user = $this ->getUser();

        if($user && !$user->isVerified()){
          return $this->render("registration/please-verify-email.html.twig");
        };

        return $this->render('dashboard/index.html.twig');
    }
}
