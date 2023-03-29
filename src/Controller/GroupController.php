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
    #[Route('/add-group', name: 'add_group')]
    public function addGroup(Request $request, EntityManagerInterface $entityManager): Response
    {
        $group = new Group();
//        $user = $request->getUser();
        
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

//            $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'first@user.com']);
            $group = $form->getData();
//            $user->addGroupsUser($group);
//            $group->addUser($user);
            $group->addUser($this->getUser());
            $entityManager->persist($group);
            $entityManager->flush();

            $this->addFlash('success', 'Success');
            return $this->redirectToRoute('app_santa');
        }

        return $this->render('group/group.html.twig', [
            'groupForm' => $form->createView(),
        ]);
    }
}