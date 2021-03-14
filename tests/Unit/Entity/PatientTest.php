<?php

namespace App\Tests\Unit\Entity;

use App\Entity\User\Patient;

class PatientTest extends EntityTestCase
{
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
}
