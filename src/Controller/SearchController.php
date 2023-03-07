<?php

namespace App\Controller;

use App\Form\SearchBarType;
use App\Form\SearchUserBarType;
use App\Repository\FranchiseRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/search')]
class SearchController extends AbstractController
{
    #[Route('/user/{search}', name: 'app_search_user', methods: ['GET', 'POST'])]
    public function searchUser($search, UserRepository $userRepository, Request $request): Response
    {
      $form = $this->createForm(SearchUserBarType::class);
      if($search != null && $search != 'all'){
        $users = $userRepository->search($search);
        $usersQty = count($users);
      } else {
        $users = $userRepository->findAll();
        $usersQty = count($users);
      }

      return new JsonResponse(
        $this->renderView('user/index.html.twig', [
        'users' => $users,
        'usersQty' => $usersQty,
        'form' => $form->createView(),
        ])
        );
    }

    #[Route('/franchise/{search}', name: 'app_search_active_franchise', methods: ['GET', 'POST'])]
    public function searchActiveFranchise($search, FranchiseRepository $franchiseRepository, Request $request): Response
    {
      $form = $this->createForm(SearchBarType::class);
      if($search != null && $search != 'all'){
        $allFranchises = $franchiseRepository->search($search);
        $franchisesQty = count($allFranchises);
      } else {
        $allFranchises = $franchiseRepository->findAll();
        $franchisesQty = count($allFranchises);
      }

      $filtered = false;

      return new JsonResponse(
        $this->renderView('franchise/index.html.twig', [
        'allFranchises' => $allFranchises,
        'franchises' => $allFranchises,
        'franchisesQty' => $franchisesQty,
        'form' => $form->createView(),
        'filtered' => $filtered
        ])
        );
    }
}
