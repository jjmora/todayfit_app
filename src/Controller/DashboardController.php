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

        //User is connected BUT is NOT verified
        if($user && !$user->isVerified()){
          return $this->render("registration/please-verify-email.html.twig");
        };
        
        //User is connected and verified BUT has NOT reset the password
        if($user && !$user->isPasswordReset()){
          //send to reset password page
          return $this->render("reset_password/please_reset_password.html.twig");
        }

        // User is connected, verified and has reset the password
        if($user){
          // send to final page 
          return $this->render("registration/redirect_to_website.html.twig", [
            'user' => $user
          ]);
        }
        
        // user is not connected
        $this->addFlash('error', "Vous n'êtes pas connecté(e)");
        //$this->addFlash('success', 'Congrats');
        return $this->redirectToRoute('app_login');
        return $this->render('dashboard/index.html.twig');
    }
}
