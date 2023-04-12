<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Group;
use App\Entity\User;

class AppFixtures extends Fixture
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }
    public function load(ObjectManager $manager, ): void
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        for ($i = 0; $i < count($users); $i++){
            $listId[] = $users[$i]->getId();
        }

        for ($i = 0; $i < 3; $i++) {
            $randomKey = array_rand($users);
            $randomObject = $users[$randomKey];
            $product = new Group();
            $product->setName('group from fixtures '.$i);
            $product->addUser($randomObject);
            $product->setMainAuthor($randomObject);
            $manager->persist($product);
        }

        $manager->flush();
//        how to get random object from php array, return type must be the object?
    }
}
