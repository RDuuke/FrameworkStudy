<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\RouterTwigExtension;
use Psr\Container\ContainerInterface;

return [
    'database.host' => 'localhost',
    'database.username' => 'root',
    'database.password' => '',
    'database.name' => 'framework',
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views',
    'twig.extensions' => [
        \DI\get(RouterTwigExtension::class)
    ],
    \Framework\Router::class => \DI\object(),
    RendererInterface::class => \DI\factory(TwigRendererFactory::class),
    \PDO::class => function(ContainerInterface $c) {
            return new PDO(
            'mysql:host=' . $c->get('database.host') .
            ';dbname=' . $c->get('database.name'),
            $c->get('database.username'),
            $c->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
];