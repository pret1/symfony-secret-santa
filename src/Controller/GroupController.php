<?php

namespace App\Controller;

use App\Form\GroupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class GroupController extends AbstractController
{
    #[Route('/add-group', name: 'add_group')]
    public function addGroup(Request $request, EntityManagerInterface $entityManager): Response
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $form->getData();
            $entityManager->persist($author);
            $entityManager->flush();

            $this->addFlash('success', 'Success');
            return $this->redirectToRoute('app_santa');
        }

        return $this->render('group/group.html.twig', [
            'groupForm' => $form->createView(),
        ]);
    }
}