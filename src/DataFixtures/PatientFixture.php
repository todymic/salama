<?php

namespace App\DataFixtures;

use App\Entity\User\Patient;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PatientFixture extends UserFixture
{

    public function load(ObjectManager $manager)
    {
        /** @var  $fake */
        $fake = Faker\Factory::create();
        $patient = new Patient();

        $patient->setFirstName($fake->name());
        $patient->setLastName($fake->name());
        $patient->setEmail('t@t.t');
        $patient->setPassword($this->passwordEncoder->encodePassword($patient, 'test'));
        $patient->setGender('M');
        $patient->setCivility('Mr');

        $manager->persist($patient);

        $manager->flush();
    }
}
