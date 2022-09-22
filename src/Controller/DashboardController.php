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
        
        if($user && !$user->isPasswordReset()){
          //send to reset password page
          return $this->render("reset_password/please_reset_password.html.twig");
        }
        if($user){
          // send to final page 
          return $this->render("registration/redirect_to_website.html.twig");
        }
        
        $this->addFlash('error', 'Oooopss.');
        $this->addFlash('success', 'Congrats');
        return $this->render('dashboard/index.html.twig');
    }
}
