<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Form\PermissionType;
use App\Repository\PermissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/permission')]
class PermissionController extends AbstractController
{
    #[Route('/', name: 'app_permission_index', methods: ['GET'])]
    public function index(PermissionRepository $permissionRepository): Response
    {
      if (!$this->isGranted('ROLE_ADMIN')) {
        $this->addFlash('error', "Vous n'avez pas le droit d'accèder");
        
        return $this->redirectToRoute('app_dashboard');
      }
    
      return $this->render('permission/index.html.twig', [
            'permissions' => $permissionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_permission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PermissionRepository $permissionRepository): Response
    {
        $permission = new Permission();
        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $permissionRepository->add($permission, true);

            return $this->redirectToRoute('app_permission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('permission/new.html.twig', [
            'permission' => $permission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_permission_show', methods: ['GET'])]
    public function show(Permission $permission): Response
    {
      return $this->redirectToRoute('app_permission_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_permission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Permission $permission, PermissionRepository $permissionRepository): Response
    {
        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $permissionRepository->add($permission, true);

            $this->addFlash('success', "La Permission a bien été mise à jour");
            return $this->redirectToRoute('app_permission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('permission/edit.html.twig', [
            'permission' => $permission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_permission_delete', methods: ['POST'])]
    public function delete(Request $request, Permission $permission, PermissionRepository $permissionRepository): Response
    {

      if ($this->isCsrfTokenValid('delete'.$permission->getId(), $request->request->get('_token'))) {
        $permissionRepository->remove($permission, true);
        $this->addFlash('error', "La Permission a bien été supprimée");
      }

      return $this->redirectToRoute('app_permission_index', [], Response::HTTP_SEE_OTHER);
    }
}
