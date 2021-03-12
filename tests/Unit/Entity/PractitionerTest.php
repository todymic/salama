<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User\Practitioner;
use Doctrine\Persistence\ObjectManager;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PractitionerTest extends KernelTestCase
{
    use FixturesTrait;

    /**
     * @var ObjectManager
     */
    private $entityManager;

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

    public function testAddNewPractioner(): void
    {
        /** @var Practitioner $practitioner */
        $practitioner = $this->entityManager->getRepository(Practitioner::class)->findOneBy(
            [
                'id' => 1
            ]
        );

        $this->assertInstanceOf(Practitioner::class, $practitioner);
        $this->assertContains('ROLE_PRACTITIONER', $practitioner->getRoles());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
