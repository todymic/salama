<?php

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Doctrine\Persistence\ObjectManager;
use Liip\TestFixturesBundle\Test\FixturesTrait;

class SearchPractitionerTest extends ApiTestCase
{
    use FixturesTrait;

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->loadFixtures(
            [
                "App\DataFixtures\PractitionerFixture",
            ]
        );

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /** @test */
    public function getListPractioners(): void
    {
        $response = static::createClient()->request('GET', '/api/practitioners');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/api/practitioners']);
    }

    /** @test */
    public function getOnePractioner(): void
    {
        $response = static::createClient()->request('GET', '/api/practitioners/1');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/api/practitioners/1']);
    }
}
