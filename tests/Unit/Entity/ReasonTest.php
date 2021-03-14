<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Reason;
use App\Entity\Speciality;

class ReasonTest extends EntityTestCase
{
    /**
     * @test
     */
    public function loadReason()
    {
        $this->loadFixtures(
            [
                "App\DataFixtures\ReasonFixture",
            ]
        );

        /** @var Reason $reason */
        $reason = $this->entityManager->getRepository(Reason::class)->findOneBy(
            [
                'id' => 1
            ]
        );

        $this->assertInstanceOf(Reason::class, $reason);
        $this->assertEquals('consultation', $reason->getConstant());

        $this->assertInstanceOf(Speciality::class, $reason->getCategory());
        $this->assertEquals('Gynecologue', $reason->getCategory()->getTitle());
    }
}
