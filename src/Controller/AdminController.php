<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
      // if (!$this->isGranted('ROLE_ADMIN')) {
      //   $this->addFlash('error', "Vous n'avez pas le droit d'accèder");
        
      //   return $this->redirectToRoute('app_dashboard');
      // }

        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");

        /** @var User $user */
        $user = $this ->getUser();

        return match ($user->isVerified()){
          true => $this->render("admin/index.html.twig"),
          false => $this->render("admin/please-verify-email.html.twig"),
        };

        return $this->render('admin/index.html.twig');
    }
}
