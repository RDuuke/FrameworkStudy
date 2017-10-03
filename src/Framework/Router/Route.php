<?php
namespace Framework\Router;

/**
 * Class Route
 * Represent a matched route
 * @package Framework\Router
 */
class Route
{
    private $name;
    /**
     * @var callable
     */
    private $callback;
    /**
     * @var array
     */
    private $parameters;

    public function __construct($name, callable $callback, array $parameters)
    {

        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Get the URL parameters
     * @return string[]
     */
    public function getParams()
    {
        return $this->parameters;
    }
}
