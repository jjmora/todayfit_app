<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Form\PartnerType;
use App\Form\PartnerEditType;
use App\Form\SearchBarType;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/structure')]
class PartnerController extends AbstractController
{

    #[Route('/monStructure', name: 'app_my_partner_show', methods: ['GET'])]
    public function showMyClub(PartnerRepository $partnerRepository): Response
    { 
        if($this->getUser()){
          
          if($this->getUser()->getPartner() != null){
            $partner = $partnerRepository->find($this->getUser()->getPartner()->getId());
          } else {
            $partner = null;
          }  

          return $this->render('partner/show.html.twig', [
              'partner' => $partner,
          ]);
        }

        $this->addFlash('error', "Vous n'avez pas le droit d'acceder");
        return $this->redirectToRoute('app_dashboard');

    }

    #[Route('/{page?1}', name: 'app_partner_index', methods: ['GET', 'POST'])]
    public function index(PartnerRepository $partnerRepository, Request $request, $page): Response
    {
      
        if (!$this->isGranted('ROLE_ADMIN')) {
          $this->addFlash('error', "Vous n'avez pas le droit d'accèder");
          
          return $this->redirectToRoute('app_dashboard');
        }
        
        $filtered = false;
        
        $allPartners = $partnerRepository->findAll();

        // PAGINATION
        $page = (int)$page;
        $qty = 3;
        $qtyPartners = $partnerRepository->count([]); 
        $qtyPages = ceil($qtyPartners / $qty);
        $partners = $partnerRepository->findBy(
          [],
          null,
          $qty,
          ($page - 1)*$qty
        );

        $form = $this->createForm(SearchBarType::class);
        $search = $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
          $partners = $partnerRepository->search($search->get('input_data')->getData(), $search->get('active')->getData());
          $filtered = true;
        }
      
        return $this->render('partner/index.html.twig', [
          'allPartners' => $allPartners,
          'partners' => $partners,
          'qtyPages' => $qtyPages,
          'page' => $page,
          'qty' => $qty,
          'form' => $form->createView(),
          'filtered' => $filtered,
        ]);
    }

    #[Route('/new/structure', name: 'app_partner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PartnerRepository $partnerRepository): Response
    {
        $partner = new Partner();
        $form = $this->createForm(PartnerType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerRepository->add($partner, true);

            return $this->redirectToRoute('app_partner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partner/new.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_partner_show', methods: ['GET'])]
    public function show(Partner $partner): Response
    {
        return $this->render('partner/show.html.twig', [
            'partner' => $partner,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_partner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partner $partner, PartnerRepository $partnerRepository): Response
    {
        $form = $this->createForm(PartnerEditType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $partnerRepository->add($partner, true);

            return $this->redirectToRoute('app_partner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partner/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_partner_delete', methods: ['POST'])]
    public function delete(Request $request, Partner $partner, PartnerRepository $partnerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {
            $partnerRepository->remove($partner, true);
        }

        return $this->redirectToRoute('app_partner_index', [], Response::HTTP_SEE_OTHER);
    }
}
