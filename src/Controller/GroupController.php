<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\GroupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class GroupController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

    #[Route('/add-group', name: 'add_group')]
    public function addGroup(Request $request): Response
    {
        $group = new Group();

        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $group = $form->getData();
            $group->addUser($this->getUser());
            $this->entityManager->persist($group);
            $this->entityManager->flush();

            $this->addFlash('success', 'Success');

            return $this->redirectToRoute('app_santa');
        }

        return $this->render('group/group.html.twig', [
            'groupForm' => $form->createView(),
        ]);
    }

    #[Route('/show-group/{id}', name: 'show_group')]
    public function showGroup($id): Response
    {
        $group = $this->entityManager->getRepository(Group::class)->find($id);

        return $this->render('group/show_group.html.twig', [
            'group' => $group
        ]);
    }

    #[Route('/add-user-to-group/{id}', name: 'add_user_to_group')]
    public function addUserToGroup($id):Response
    {
        $group = $this->entityManager->getRepository(Group::class)->find($id);
        $group->addUser($this->getUser());
        $this->entityManager->persist($group);
        $this->entityManager->flush();
        $this->addFlash('success', 'Success');

        return $this->redirectToRoute('app_santa');
    }

    #[Route('/delete-user-from-group/{id}', name: 'delete_user_from_group')]
    public function deleteUserFromGroup($id): Response
    {
        $group = $this->entityManager->getRepository(Group::class)->find($id);
        $group->removeUser($this->getUser());
        $this->entityManager->persist($group);
        $this->entityManager->flush();
        $this->addFlash('success', 'Success');

        return $this->redirectToRoute('app_santa');
    }
}