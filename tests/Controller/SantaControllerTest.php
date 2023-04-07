<?php


namespace App\Tests\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SantaControllerTest extends WebTestCase
{
    /** @var EntityManagerInterface $entityManager */
    protected $entityManager;
    protected $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
//        $this->container = static::createClient()->getContainer();
    }

    public function testIndex()
    {

//     Arrange
//        $client = static::createClient();
//        $entityManager = $client->getContainer()->get('doctrine')->getManager();


//     Act
        $this->client->request('GET', '/');

//     Assert
        $this->assertResponseIsSuccessful();
//        $this->assertSelectorTextContains('h1', 'Join to secret Santa');
        $this->assertResponseStatusCodeSame(200);
    }

    public function testItWorks()
    {
        $this->assertTrue(true);
    }
}