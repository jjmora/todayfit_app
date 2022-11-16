<?php

namespace App\Controller;

use App\Repository\FranchiseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReactController extends AbstractController
{
    #[Route('/react', name: 'app_react')]
    public function index(FranchiseRepository $franchiseRepository): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $allFranchises = $franchiseRepository->findAll();

        $variable = $allFranchises[0]->getName();

        $jsonContent = $serializer->serialize($allFranchises, 'json');

        dd($jsonContent);

        return $this->render('react/index.html.twig', [
            'franchises' => $allFranchises,
            'variable' => $variable
        ]);
    }
}
