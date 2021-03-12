<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class SecurityContext
 * @package App\Tests\Behat
 */
abstract class AbstractContext implements Context
{
    /** @var KernelInterface */
    protected $kernel;
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;
    /**
     * @var Connection
     */
    protected $connection;
    /**
     * @var Application
     */
    protected $application;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * SecurityContext constructor.
     * @param KernelInterface $kernel
     * @param EntityManagerInterface $entityManager
     * @param Connection $connection
     */
    public function __construct(
        KernelInterface $kernel,
        EntityManagerInterface $entityManager,
        Connection $connection
    ) {
        $this->kernel = $kernel;

        $this->entityManager = $entityManager;
        $this->connection = $connection;
        $this->application = new Application($kernel);
        $this->application->setAutoExit(false);


        $this->container = $kernel->getContainer();

        $this->entityManager = $this->container->get('doctrine.orm.default_entity_manager');
    }


    /**
     * @param string $name
     * @param array $dependecies
     * @throws InvalidArgumentException
     */
    protected function loadFixture(string $name, $dependecies = [])
    {
        if (!class_exists('App\DataFixtures\\' . $name . 'Fixture')) {
            throw new InvalidArgumentException($name . " don't exist");
        }

        $className = 'App\DataFixtures\\' . $name . 'Fixture';

        $loader = new Loader();

        if (is_array($dependecies)) {
            $loader->addFixture(new $className(...$dependecies));
        } else {
            $loader->addFixture(new $className());
        }

        $executor = new ORMExecutor($this->entityManager);
        $executor->execute($loader->getFixtures(), true);
    }
}
