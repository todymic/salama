<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Degree;
use App\Entity\Language;
use App\Entity\Speciality;
use App\Entity\User\Practitioner;

/**
 * Class PractitionerTest
 * @package App\Tests\Unit\Entity
 */
class PractitionerTest extends EntityTestCase
{
    public function testNewPractitioner(): void
    {
        $this->loadFixtures(
            [
                "App\DataFixtures\PractitionerFixture",
            ]
        );

        /** @var Practitioner $practitioner */
        $practitioner = $this->entityManager->getRepository(Practitioner::class)->findOneBy(
            [
                'id' => 1
            ]
        );

        $this->assertInstanceOf(Practitioner::class, $practitioner);
        $this->assertContains('ROLE_PRACTITIONER', $practitioner->getRoles());

        /** @var Degree $degree */
        $degree = $practitioner->getDegrees()->first();
        $this->assertInstanceOf(Degree::class, $degree);
        $this->assertEquals('Diplome de Medecin', $degree->getTitle());

        /** @var Language $language */
        $language = $practitioner->getLanguages()->first();
        $this->assertInstanceOf(Language::class, $language);
        $this->assertEquals('fr', $language->getValue());

        /** @var Speciality $speciality */
        $speciality = $practitioner->getSpecialities()->first();
        $this->assertInstanceOf(Speciality::class, $speciality);
        $this->assertEquals('Gynecologue', $speciality->getTitle());
    }
}
