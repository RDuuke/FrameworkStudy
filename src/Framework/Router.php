<?php

namespace Framework;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;
use Framework\Router\Route;

/*
 * Register and match route
 */
class Router
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    /**
     * @param $path
     * @param callable $callable
     * @param $name
     */
    public function get($path, callable $callable, $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    /**
     * @param ServerRequestInterface $request
     * @return Route||null
     */
    public function match(ServerRequestInterface $request)
    {
        $result = $this->router->match($request);
        if ($result->isSuccess() == true) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;
    }

    public function generateUri($name, array $params)
    {
        return $this->router->generateUri($name, $params);
    }
}
