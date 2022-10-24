<?php

namespace App\Controller;

use App\Repository\FranchiseRepository;
use App\Repository\PartnerRepository;
use App\Repository\PermissionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(UserRepository $userRepository, FranchiseRepository $franchiseRepository, PartnerRepository $partnerRepository, PermissionRepository $permissionRepository): Response
    {
      // if (!$this->isGranted('ROLE_ADMIN')) {
      //   $this->addFlash('error', "Vous n'avez pas le droit d'accèder");
        
      //   return $this->redirectToRoute('app_dashboard');
      // }

        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");

        /** @var User $user */
        $user = $this ->getUser();

        if(!$user->isVerified()){
          return $this->render("registration/please-verify-email.html.twig");
        };

        $allUsers = count($userRepository->findAll());
        $allFranchises = count($franchiseRepository->findAll());
        $allStructures = count($partnerRepository->findAll());
        $allPermissions = count($permissionRepository->findAll());
        
        $adminQty = $userRepository->count(array('roles' => array('["ROLE_ADMIN"]')));
        $franchiseQty = $userRepository->count(array('roles' => array('["ROLE_FRANCHISE"]')));
        $partnerQty = $userRepository->count(array('roles' => array('["ROLE_PARTNER"]')));
        $noRoleQty = $allUsers - $adminQty - $franchiseQty - $partnerQty;
        
        $franchiseActiveCount = $franchiseRepository->count(array('Active' => true));
        $franchiseInactiveCount = $franchiseRepository->count(array('Active' => false));

        $partnerActiveCount = $partnerRepository->count(array('Active' => true));
        $partnerInactiveCount = $partnerRepository->count(array('Active' => false));

        return $this->render('admin/index.html.twig', [
          'allUsers' => $allUsers,
          'allFranchises' => $allFranchises,
          'allStructures' => $allStructures,
          'allPermissions' => $allPermissions,
          'franchiseActiveCount' => $franchiseActiveCount,
          'franchiseInactiveCount' => $franchiseInactiveCount,
          'partnerActiveCount' => $partnerActiveCount,
          'partnerInactiveCount' => $partnerInactiveCount,
          'adminQty' => $adminQty,
          'franchiseQty' => $franchiseQty,
          'partnerQty' => $partnerQty,
          'noRoleQty' => $noRoleQty,
        ]);
    }
}
