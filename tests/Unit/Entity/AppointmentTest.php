<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Appointment;
use App\Entity\Availability;
use App\Entity\Reason;
use App\Entity\User\Patient;
use App\Entity\User\Practitioner;
use DateTime;

/**
 * Class AppointmentTest
 * @package App\Tests\Unit\Entity
 */
class AppointmentTest extends EntityTestCase
{
    public function testNewAppointment(): void
    {
        $this->loadFixtures(
            [
                "App\DataFixtures\AppointmentFixture",
            ]
        );

        /** @var Appointment $appointment */
        $appointment = $this->entityManager->getRepository(Appointment::class)->findOneBy(
            [
                'id' => 1
            ]
        );

        $this->assertNull($appointment->getDescription());
        $this->assertInstanceOf(Patient::class, $appointment->getPatient());
        $this->assertEquals(1, $appointment->getPatient()->getId());

        $this->assertInstanceOf(Practitioner::class, $appointment->getPractitioner());
        $this->assertEquals(2, $appointment->getPractitioner()->getId());

        $this->assertInstanceOf(Reason::class, $appointment->getReason());
        $this->assertEquals('consultation', $appointment->getReason()->getDescription());
        $this->assertEquals(3, $appointment->getReason()->getId());

        $this->assertEquals(Appointment::WAITING_PRACTITIONER_STATUS, $appointment->getStatus());

        $this->assertInstanceOf(Availability::class, $appointment->getAvailability());
        $this->assertEquals(Availability::BUSY, $appointment->getAvailability()->getStatus());


        $this->assertEquals((new DateTime())->format('Y-m-d'), $appointment->getCreatedAt()->format('Y-m-d'));
        $this->assertNull($appointment->getDeletedAt());
        $this->assertNull($appointment->getUpdatedAt());
    }
}
