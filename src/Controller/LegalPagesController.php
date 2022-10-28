<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/legal')]
class LegalPagesController extends AbstractController
{
    #[Route('/conditions-generales', name: 'app_legal_conditions')]
    public function conditions(): Response
    {
        return $this->render('legal_pages/conditions.html.twig');
    }

    #[Route('/mentions-legales', name: 'app_legal_code')]
    public function code(): Response
    {
        return $this->render('legal_pages/code.html.twig');
    }
}
