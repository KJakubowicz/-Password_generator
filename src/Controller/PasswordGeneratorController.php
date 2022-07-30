<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PasswordGeneratorController extends AbstractController
{
    #[Route('/password/generator', name: 'app_password_generator')]
    public function index(): JsonResponse
    {die;
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PasswordGeneratorController.php',
        ]);
    }
}
