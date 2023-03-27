<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Group;

class SantaController extends AbstractController
{
    #[Route('/', name: 'app_santa')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $groups = $entityManager->getRepository(Group::class)->findAll();
        return $this->render('santa/index.html.twig', [
            'groups' => $groups,
        ]);
    }
}
