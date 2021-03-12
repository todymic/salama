<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User\Practitioner;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientTest extends KernelTestCase
{
    use FixturesTrait;

    /**
     * @var \Doctrine\Persistence\ObjectManager
     */
    private $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->loadFixtures([
            "App\DataFixtures\PractitionerFixture",
        ]);

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testAddNewPatient(): void
    {

        $practitioner = $this->entityManager->getRepository(Practitioner::class)->findOneBy([
            'id' => 1
        ]);

        $this->assertInstanceOf(Practitioner::class, $practitioner);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
