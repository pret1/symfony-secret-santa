<?php

namespace App\Tests\Controller;

use App\Controller\GroupController;
use App\Entity\Group;
use App\Entity\User;
use App\Form\GroupType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GroupControllerTest extends WebTestCase
{
    use SecurityMockeryTrait;

    /** @var EntityManagerInterface|object|null */
    private ?EntityManagerInterface $entityManager = null;
    protected $client;

    protected function setUp(): void
    {
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
        $this->client = static::createClient();
        $this->setupSecurity();

    }


    public function testAddGroup(): void
    {
        // Create a new Group object and populate the form data
        $group = new Group();
        $group->setName('Test Group');

        $formData = [
            'group' => [
                'name' => 'Unit Test Group',
            ],
        ];

        // Submit the form data and follow any redirects
        $crawler = $this->client->request('POST', '/add-group');
        $form = $crawler->selectButton('Save')->form();
        $this->client->submit($form, $formData);
        $this->client->followRedirect();

        // Assert that the response is successful and the Group was created
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertCount(1, $this->entityManager->getRepository(Group::class)->findAll());
        $this->assertSame('Test Group', $this->entityManager->getRepository(Group::class)->findOneBy([])->getName());
    }

}
