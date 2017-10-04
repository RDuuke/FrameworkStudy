<?php

namespace Framework\Router;

use Framework\Router;

class RouterTwigExtension extends \Twig_Extension
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {

        $this->router = $router;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('path', [$this, 'pathFor'])
        ];
    }

    public function pathFor($path, array $params = [])
    {
        return $this->router->generateUri($path, $params);
    }
}
