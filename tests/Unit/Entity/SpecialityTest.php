<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Reason;
use App\Entity\Speciality;

class SpecialityTest extends EntityTestCase
{
    /** @test */
    public function loadSpeciality()
    {
        $this->loadFixtures(
            [
                "App\DataFixtures\SpecialityFixture",
            ]
        );

        /** @var Speciality $speciality */
        $speciality = $this->entityManager->getRepository(Speciality::class)->findOneBy(
            [
                'id' => 1,
            ]
        );

        $this->assertInstanceOf(Speciality::class, $speciality);
        $this->assertEquals('Gynecologue', $speciality->getTitle());

        $this->assertInstanceOf(Reason::class, $speciality->getReasons()->first());
        $this->assertEquals('consultation', $speciality->getReasons()->first()->getConstant());
    }
}
