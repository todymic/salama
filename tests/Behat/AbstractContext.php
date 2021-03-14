<?php

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Tester\CommandTester;
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
     * @var SchemaTool
     */
    private $schemaTool;
    /**
     * @var ClassMetadata[]
     */
    private $metadata;

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
     * @BeforeScenario
     * @throws Exception
     */
    public function initDb()
    {
//        $metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();
//        $schemaTool = new SchemaTool($this->entityManager);
//        $schemaTool->dropDatabase();
//        if (!empty($metaData)) {
//            $schemaTool->createSchema($metaData);
//        }


        $this->executeCommand('d:d:drop', ['--force' => true]);
        $this->executeCommand('d:d:create');
        $this->executeCommand('d:sch:create');
    }


    /**
     * @param string $commandName
     * @param array $parameters
     * @throws Exception
     */
    private function executeCommand(string $commandName, array $parameters = [])
    {
        $options = ['--env' => 'test'];
        if (!empty($parameters)) {
            $options = array_merge($options, $parameters);
        }

        $command = $this->application->find($commandName);
        $commandTester = new CommandTester($command);
        $commandTester->execute($options);
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

        $purger = new ORMPurger($this->entityManager);

        $executor = new ORMExecutor($this->entityManager, $purger);
        $executor->execute($loader->getFixtures(), true);
    }
}
