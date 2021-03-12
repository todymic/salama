<?php

namespace App\DataFixtures;

use App\Entity\User\Practitioner;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PractitionerFixture extends UserFixture
{

    public function load(ObjectManager $manager)
    {
        /** @var  $fake */
        $fake = Faker\Factory::create();
        $partitionner = new Practitioner();

        $partitionner->setFirstName($fake->name());
        $partitionner->setLastName($fake->name());
        $partitionner->setEmail('t@t.t');
        $partitionner->setPassword($this->passwordEncoder->encodePassword($partitionner, 'test'));

        $manager->persist($partitionner);

        $manager->flush();
    }
}
