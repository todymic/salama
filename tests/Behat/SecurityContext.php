<?php

namespace App\Tests\Behat;

use App\Entity\User\Practitioner;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Webmozart\Assert\Assert;

/**
 * Class SecurityContext
 * @package App\Tests\Behat
 */
final class SecurityContext extends AbstractContext implements Context
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(
        KernelInterface $kernel,
        EntityManagerInterface $entityManager,
        Connection $connection,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        parent::__construct($kernel, $entityManager, $connection);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Given the :name state
     *
     * @param string $name
     * @throws InvalidArgumentException
     */
    public function loadState(string $name)
    {
        if (!class_exists('App\DataFixtures\\' . $name . 'Fixture')) {
            throw new InvalidArgumentException($name . " don't exist");
        }

        parent::loadFixture($name, [$this->passwordEncoder]);

        $practitionerRepo = $this->kernel->getContainer()
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository(Practitioner::class);
        $practitioner = $practitionerRepo->findOneBy(
            [
                'id' => 1
            ]
        );

        Assert::isInstanceOf($practitioner, Practitioner::class);
    }
}
