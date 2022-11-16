<?php

namespace App\Controller;

use App\Repository\FranchiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReactController extends AbstractController
{
    #[Route('/react', name: 'app_react')]
    public function index(FranchiseRepository $franchiseRepository): Response
    {
        $allFranchises = $franchiseRepository->findAll();

        return $this->render('react/index.html.twig', [
            'all_franchises' => 'allFranchises',
        ]);
    }
}
