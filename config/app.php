<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

return [
    'app_name' => 'Schedule',
    'routes' => [
        'home' => [
            'path' => '/',
            'default' => 'index',
            'controller' => IndexController::class,
        ],
    ],
];

