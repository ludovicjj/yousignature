<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api', name: "api_")]
class ApiController extends AbstractController
{
    #[Route("/", name: "api_index")]
    public function index(): Response
    {
        return $this->json(['message' => 'If you this this response your IP is in white listed IP']);
    }
}