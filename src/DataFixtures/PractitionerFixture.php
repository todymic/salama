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
        $partitionner->setEmail($fake->email);
        $partitionner->setPassword($this->passwordEncoder->encodePassword($partitionner, 'test'));
        $partitionner->setRoles(['ROLE_PRACTITIONER']);

        $manager->persist($partitionner);

        $this->setReference(Practitioner::class, $partitionner);

        $manager->flush();
    }
}
