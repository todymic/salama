<?php

namespace App\Tests\Unit\Entity;

use Doctrine\Persistence\ObjectManager;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class EntityTestCase
 * @package App\Tests\Unit\Entity
 */
abstract class EntityTestCase extends KernelTestCase
{
    use FixturesTrait;

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     *
     */
    public function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     *
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
