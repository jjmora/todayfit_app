<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\Partner;
use App\Form\FranchiseType;
use App\Form\FranchiseEditType;
use App\Form\SearchBarType;
use App\Repository\FranchiseRepository;
use App\Repository\PartnerRepository;
use App\Repository\PermissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

#[Route('/franchise')]
class FranchiseController extends AbstractController
{
    #[Route('/mafranchise', name: 'app_my_franchise_show', methods: ['GET', 'POST'])]
    public function showMyFranchise(FranchiseRepository $franchiseRepository, PartnerRepository $partnerRepository, Request $request): Response
    { 
        if($this->getUser()){
          
          if($this->isGranted('ROLE_ADMIN')){
            $this->addFlash('error', "Vous êtes Admin. Entrez comme Franchise pour voir ce contenu");
            return $this->redirectToRoute('app_dashboard');
          }

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

    #[Route('/mafranchise/structure/{id}', name: 'app_franchise_partner_show', methods: ['GET'])]
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


    // JSON RESPONSE
    #[Route('/franchise_json', name: 'app_franchise_json')]
    public function index_json(FranchiseRepository $franchiseRepository, PermissionRepository $permissionRepository): JsonResponse
    {
        
        $allFranchises = $franchiseRepository->findAll();
        $allPermissions = $permissionRepository->findAll();

        $franchisesArray = [];
        $j = 0;
        //TO DO - PUT IN SERVICE
        foreach($allFranchises as $franchise){
          $franchisesArray[$j] = array(
            "id" => $franchise->getId(), 
            "name" => $franchise->getName(), 
            "email_perso" => $franchise->getEmail(), 
            "email" => $franchise->getUser()->getEmail(),
            "image" => $franchise->getImage(),
            "description" => $franchise->getDescription(),
            "permissions" => $franchise->getPermissions(),
            "date" => $franchise->getDate(),
            "isActive" => $franchise->isActive()
          );
          $j = $j + 1;
        }

        $permissionsArray = [];
        $i = 0;
        foreach($allPermissions as $permission){
          $permissionsArray[$i] = array(
            "id" => $permission->getId(), 
            "name" => $permission->getName(), 
            "image" => $permission->getImage() 
          );
          $i = $i + 1;
        }
       
        $variable = $allFranchises[0]->getName();
        
        return $this->json([
          'code' => 200,
          'nb_of_results' => count($allFranchises),
          'variable' => $variable,
          'franchisesArray' => $franchisesArray,
          'permisions' => $permissionsArray,
          'franchises' => $allFranchises
          ], 200, [], [ObjectNormalizer::CIRCULAR_REFERENCE_HANDLER => function($object){
            return $object->getId();
            }
          ]);
    }
    // JSON RESPONSE


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
        $qty = 6;
        $qtyFranchise = $franchiseRepository->count([]); 
        $qtyPages = ceil($qtyFranchise / $qty);
        if(($page - 1)*$qty > 0) {
          $offset = ($page - 1)*$qty;
        } else {
          $offset = 0;
        }

        $franchises = $franchiseRepository->findBy(
          [],
          null,
          $qty,
          $offset
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
          $id = $franchise->getId();

          $this->addFlash('success', "La Franchise a bien été crée");

          return $this->redirectToRoute('app_franchise_show', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('franchise/new.html.twig', [
            'franchise' => $franchise,
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'app_franchise_show', methods: ['GET'])]
    public function show(Franchise $franchise): Response
    {
        $partnersCount = count($franchise->getPartner());

        return $this->render('franchise/show_admin.html.twig', [
            'franchise' => $franchise,
            'partnersCount' => $partnersCount
        ]);
    }

    #[Route('/{id}/edit', name: 'app_franchise_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Franchise $franchise, FranchiseRepository $franchiseRepository): Response
    {
        $form = $this->createForm(FranchiseEditType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $franchiseRepository->add($franchise, true);

            $id = $franchise->getId();
            $this->addFlash('success', "La Franchise a bien été mise à jour");
            return $this->redirectToRoute('app_franchise_show', [ 'id' => $id ], Response::HTTP_SEE_OTHER);
        }

        $partnersCount = count($franchise->getPartner());

        return $this->renderForm('franchise/edit.html.twig', [
            'franchise' => $franchise,
            'form' => $form,
            'partnersCount' => $partnersCount
        ]);
    }

    #[Route('/show/{id}', name: 'app_franchise_delete', methods: ['POST'])]
    public function delete(Request $request, Franchise $franchise, FranchiseRepository $franchiseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$franchise->getId(), $request->request->get('_token'))) {
            $franchiseRepository->remove($franchise, true);
            $this->addFlash('error', "La Franchise a bien été supprimée");
        }

        return $this->redirectToRoute('app_franchise_index', [], Response::HTTP_SEE_OTHER);
    }
}
