<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\RouterTwigExtension;
use Psr\Container\ContainerInterface;

return [
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views',
    'twig.extensions' => [
        \DI\get(RouterTwigExtension::class)
    ],
    \Framework\Router::class => \DI\object(),
    RendererInterface::class => \DI\factory(TwigRendererFactory::class)
];