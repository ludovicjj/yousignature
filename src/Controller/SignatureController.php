<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignatureController extends AbstractController
{
    #[Route('/signature', name: 'app_signature')]
    public function index(): Response
    {
        return $this->render('signature/index.html.twig', [
            'controller_name' => 'SignatureController',
        ]);
    }

    #[Route('/dropzone', name: "app_dropzone")]
    public function dropzone(Request $request): JsonResponse
    {
        $media = $request->files->get('file');
        $base64Content = null;
        if ($media instanceof UploadedFile) {
            $path = $media->getRealPath();
            $fileContent = file_get_contents($path);
            $base64Content = base64_encode($fileContent);
        }

        return new JsonResponse(['success' => true, "signature" => $base64Content]);
    }
}
