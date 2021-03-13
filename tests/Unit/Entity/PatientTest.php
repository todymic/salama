<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User\Patient;
use Doctrine\Persistence\ObjectManager;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PatientTest extends KernelTestCase
{
    use FixturesTrait;

    /**
     * @var ObjectManager
     */
    private $entityManager;

    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testAddNewPatient(): void
    {
        $this->loadFixtures(
            [
                "App\DataFixtures\PatientFixture",
            ]
        );

        /** @var Patient $patient */
        $patient = $this->entityManager->getRepository(Patient::class)->findOneBy(
            [
                'id' => 1
            ]
        );

        $this->assertInstanceOf(Patient::class, $patient);
        $this->assertContains('ROLE_PATIENT', $patient->getRoles());
        $this->assertEquals('M', $patient->getGender());
        $this->assertEquals('Mr', $patient->getCivility());
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
