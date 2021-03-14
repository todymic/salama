<?php

namespace App\DataFixtures;

use App\Entity\Degree;
use App\Entity\Language;
use App\Entity\Locality;
use App\Entity\Speciality;
use App\Entity\User\Practitioner;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

/**
 * Class PractitionerFixture
 * @package App\DataFixtures
 */
class PractitionerFixture extends UserFixture implements DependentFixtureInterface
{

    /**
     * @param ObjectManager $manager
     */
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

        $partitionner->setDescription('Je suis professionnel');

        $degree = new Degree();
        $degree->setTitle('Diplome de Medecin');
        $partitionner->addDegree($degree);

        /** @var Language $language */
        $language = $this->getReference(Language::class);
        $partitionner->addLanguage($language);

        /** @var Speciality $speciality */
        $speciality = $this->getReference(Speciality::class);
        $partitionner->addSpeciality($speciality);

        $locality = new Locality();
        $locality->setStreetType($fake->streetSuffix);
        $locality->setStreetName($fake->streetName);
        $locality->setStreetNumber($fake->randomDigit);
        $locality->setCity($fake->city);
        $locality->setCountry($fake->country);
        $locality->setZipcode((int)$fake->postcode);

        $partitionner->addLocality($locality);

        $manager->persist($partitionner);

        $this->setReference(Practitioner::class, $partitionner);


        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            LanguageFixture::class,
            SpecialityFixture::class
        ];
    }
}
