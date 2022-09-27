<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Form\FranchiseType;
use App\Form\FranchiseEditType;
use App\Repository\FranchiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/franchise')]
class FranchiseController extends AbstractController
{
    #[Route('/', name: 'app_franchise_index', methods: ['GET'])]
    public function index(FranchiseRepository $franchiseRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
          $this->addFlash('error', "Vous n'avez pas le droit d'accèder");
          
          return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('franchise/index.html.twig', [
            'franchises' => $franchiseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_franchise_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FranchiseRepository $franchiseRepository): Response
    {
        $franchise = new Franchise();
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $franchiseRepository->add($franchise, true);

            return $this->redirectToRoute('app_franchise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('franchise/new.html.twig', [
            'franchise' => $franchise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_franchise_show', methods: ['GET'])]
    public function show(Franchise $franchise): Response
    {
        return $this->render('franchise/show.html.twig', [
            'franchise' => $franchise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_franchise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Franchise $franchise, FranchiseRepository $franchiseRepository): Response
    {
        $form = $this->createForm(FranchiseEditType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $franchiseRepository->add($franchise, true);

            return $this->redirectToRoute('app_franchise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('franchise/edit.html.twig', [
            'franchise' => $franchise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_franchise_delete', methods: ['POST'])]
    public function delete(Request $request, Franchise $franchise, FranchiseRepository $franchiseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$franchise->getId(), $request->request->get('_token'))) {
            $franchiseRepository->remove($franchise, true);
        }

        return $this->redirectToRoute('app_franchise_index', [], Response::HTTP_SEE_OTHER);
    }
}
