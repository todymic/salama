<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Language;

class LanguageTest extends EntityTestCase
{
    /** @test */
    public function loadLanguage()
    {
        $this->loadFixtures(
            [
                "App\DataFixtures\LanguageFixture",
            ]
        );

        /** @var Language[] $language */
        $language = $this->entityManager->getRepository(Language::class)->findAll();


        $this->assertInstanceOf(Language::class, $language[0]);
        $this->assertEquals(1, $language[0]->getId());
        $this->assertEquals('fr', $language[0]->getValue());
    }
}
