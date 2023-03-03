<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchUserBarType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user')]
class UserController extends AbstractController
{
  
  #[Route('/', name: 'app_user_index', methods: ['GET', 'POST'])]
  public function index(UserRepository $userRepository, Request $request): Response
  {
        // if (!$this->isGranted('ROLE_ADMIN')) {
        //   $this->addFlash('error', "Vous n'avez pas le droit d'accèder");
          
        //   return $this->redirectToRoute('app_dashboard');
        // }
        
        $users = $userRepository->findAll();
        $usersQty = count($users);

        $filtered = false;

        $form = $this->createForm(SearchUserBarType::class);
        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $users = $userRepository->search($search->get('input_data')->getData(), $search->get('type')->getData());
          $usersQty = count($users);
          $filtered = true;
        }

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'usersQty' => $usersQty,
            'form' => $form->createView(),
            'filtered' => $filtered,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        $partners = [];
        if($user->getFranchise()){
          $partners = $user->getFranchise()->getPartner();
        }

        $partnerArray = [];
        foreach($partners as $partner){
          $partnerArray[] = $partner;
        }



        $noAsigned = true;
        $asignedAs = '';

        if($user->getFranchise()){
          $noAsigned = false;
          $asignedAs = 'franchise';
        } else if ($user->getPartner()){
          $noAsigned = false;
          $asignedAs = 'partner';
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'partnersCount' => count($partnerArray),
            'noAsigned' => $noAsigned,
            'asignedAs' => $asignedAs,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            $this->addFlash('error', "L'utilisateur a bien été supprimé");
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
