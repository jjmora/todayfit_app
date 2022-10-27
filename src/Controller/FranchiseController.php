<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\Partner;
use App\Form\FranchiseType;
use App\Form\FranchiseEditType;
use App\Form\SearchBarType;
use App\Repository\FranchiseRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/franchise')]
class FranchiseController extends AbstractController
{
    #[Route('/maFranchise', name: 'app_my_franchise_show', methods: ['GET', 'POST'])]
    public function showMyFranchise(FranchiseRepository $franchiseRepository, PartnerRepository $partnerRepository, Request $request): Response
    { 
        if($this->getUser()){
          
          if($this->getUser()->getFranchise() != null){
            $franchise = $franchiseRepository->find($this->getUser()->getFranchise()->getId());
          } else {
            $franchise = null;
          }

          $partners = $franchise->getPartner();
          
          $form = $this->createForm(SearchBarType::class);
          $search = $form->handleRequest($request);
  
          if($form->isSubmitted() && $form->isValid()){
            $partners = $partnerRepository
              ->searchByFranchise($franchise, $search->get('input_data')->getData(), $search->get('active')->getData());
          }

          return $this->render('franchise/show.html.twig', [
              'franchise' => $franchise,
              'partners' => $partners,
              'form' => $form->createView(),
          ]);
        }

        $this->addFlash('error', "Vous n'avez pas le droit d'acceder");
        return $this->redirectToRoute('app_dashboard');

    }

    #[Route('/maFranchise/structure/{id}', name: 'app_franchise_partner_show', methods: ['GET'])]
    public function showMyPartner(Partner $partner, $id, FranchiseRepository $franchiseRepository, PartnerRepository $partnerRepository): Response
    {
        $franchise = $franchiseRepository->find($this->getUser()->getFranchise()->getId());
        $partners = $franchise->getPartner();
        //dd($this->getUser()->getFranchise());
        //dd($partnerRepository->find($id)->getFranchise());
        if( $partnerRepository->find($id)->getFranchise() != $this->getUser()->getFranchise()) {
          $this->addFlash('error', "Vous n'avez pas le droit d'acceder");
          return $this->redirectToRoute('app_dashboard');
        }

        return $this->render('partner/show.html.twig', [
            'partner' => $partner,
            'partners' => $partners
        ]);
    }

    #[Route('/{page?1}', name: 'app_franchise_index', methods: ['GET', 'POST'])]
    public function index(FranchiseRepository $franchiseRepository, Request $request, $page): Response
    {
      
        if (!$this->isGranted('ROLE_ADMIN')) {
          $this->addFlash('error', "Vous n'avez pas le droit d'accèder");
          
          //return $this->redirectToRoute('app_dashboard');
        }

        $filtered = false;

        $allFranchises = $franchiseRepository->findAll();

        // PAGINATION
        $page = (int)$page;
        $qty = 3;
        $qtyFranchise = $franchiseRepository->count([]); 
        $qtyPages = ceil($qtyFranchise / $qty);

        $franchises = $franchiseRepository->findBy(
          [],
          null,
          $qty,
          ($page - 1)*$qty
        );

        $form = $this->createForm(SearchBarType::class);
        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $franchises = $franchiseRepository->search($search->get('input_data')->getData(), $search->get('active')->getData());
          $filtered = true;
        }

        return $this->render('franchise/index.html.twig', [
            'allFranchises' => $allFranchises,
            'franchises' => $franchises,
            'qtyPages' => $qtyPages,
            'page' => $page,
            'qty' => $qty,
            'form' => $form->createView(),
            'filtered' => $filtered,
        ]);
    }

    #[Route('/new/fr', name: 'app_franchise_new', methods: ['GET', 'POST'])]
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

    #[Route('/show/{id}', name: 'app_franchise_show', methods: ['GET'])]
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
