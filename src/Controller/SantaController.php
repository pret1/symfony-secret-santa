<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SantaController extends AbstractController
{
    #[Route('/', name: 'app_santa')]
    public function index(): Response
    {
        return $this->render('santa/index.html.twig', [
            'controller_name' => 'SantaController',
        ]);
    }
}
