<?php

namespace Framework;


class Renderer
{
    const DEFAULT_NAMESPACE = '__MAIN';

    private $paths = [];

    private $globals = [];

    public function __construct()
    {
    }

    public function addPath($namespace, $path = null)
    {
        if (is_null($path)) {
            $this->paths[self::DEFAULT_NAMESPACE] = $namespace;
        } else {
            $this->paths[$namespace] = $path;
        }
    }

    public function render($view, array $params = [])
    {
        if($this->hasNamespace($view)) {
            $path = $this->replaceNamespace($view) . '.php';
        } else {
            $path = $this->paths[self::DEFAULT_NAMESPACE] . DIRECTORY_SEPARATOR . $view . '.php';
        }
        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        require($path);
        return ob_get_clean();
    }

    public function addGlobal($key, $value)
    {
        $this->globals[$key] = $value;
    }

    private function hasNamespace($view)
    {
        return $view[0] === "@";
    }

    private function getNamespace($view)
    {
        return substr($view, 1,strpos($view, '/') - 1);
    }

    private function replaceNamespace($view)
    {
        $namespace = $this->getNamespace($view);
        return str_replace('@' . $namespace, $this->paths[$namespace], $view);
    }
}