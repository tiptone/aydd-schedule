<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Doctrine\Common\Proxy\AbstractProxyFactory;
//use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Tiptone\AyddSchedule\Controller\IndexController;
use Tiptone\AyddSchedule\Controller\AccountController;
use Tiptone\AyddSchedule\Service\ClassService;
use Tiptone\AyddSchedule\Service\SectionService;

return [
    'app_name' => 'Schedule',
    'routes' => [
        'home' => [
            'path' => '/',
            'default' => 'index',
            'controller' => IndexController::class,
        ],
        'account' => [
            'path' => '/account',
            'default' => 'index',
            'controller' => AccountController::class,
        ],
    ],
    'container' => [
        'EntityManager' => function(ContainerInterface $container) {
            $config = ORMSetup::createAnnotationMetadataConfiguration(
                [__DIR__ . '/../src'],
                true,
                __DIR__ . '/../cache'
            );
            $config->setAutoGenerateProxyClasses(AbstractProxyFactory::AUTOGENERATE_FILE_NOT_EXISTS);
            //$config->setNamingStrategy(new UnderscoreNamingStrategy(CASE_UPPER));

            $connection = DriverManager::getConnection(
                [
                    'dbname' => DB_DATABASE,
                    'user' => DB_USERNAME,
                    'password' => DB_PASSWORD,
                    'host' => DB_HOSTNAME,
                    'driver' => 'pdo_mysql',
                ],
                $config
            );

            $entityManager = new EntityManager($connection, $config);

            return $entityManager;
        },
        LoggerInterface::class => DI\factory(function() {
            $logger = new Logger('schedule');
            $logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO, false));
            $logger->pushHandler(new StreamHandler('php://stderr', Logger::ERROR, false));

            return $logger;
        }),
        Environment::class => DI\factory(function() {
            $loader = new FilesystemLoader(__DIR__ . '/../templates');
            $twig = new Environment($loader);

            return $twig;
        }),
        'Db' => DI\factory(function() {
            $dsn = sprintf('mysql:host=%s;dbname=%s', DB_HOSTNAME, DB_DATABASE);

            try {
                $dbh = new \PDO($dsn, DB_USERNAME, DB_PASSWORD);
                $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                error_log($e->getMessage());
                exit;
            }

            return $dbh;
        }),
        ClassService::class => function(ContainerInterface $container) {
            return new ClassService($container->get('EntityManager'));
        },
        SectionService::class => function(ContainerInterface $container) {
            return new SectionService($container->get('EntityManager'));
        },
        IndexController::class => function(ContainerInterface $container) {
            $controller = new IndexController(
                $container->get(ClassService::class),
                $container->get(SectionService::class)
            );
            $controller->setLogger($container->get(LoggerInterface::class));

            return $controller;
        },
        AccountController::class => function(ContainerInterface $container) {
            $controller = new AccountController();
            $controller->setLogger($container->get(LoggerInterface::class));

            return $controller;
        }
    ],
];

