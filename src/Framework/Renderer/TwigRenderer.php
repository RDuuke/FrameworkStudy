<?php

namespace Framework\Renderer;

class TwigRenderer implements RendererInterface
{
    private $twig;
    private $loader;

    public function __construct($path)
    {
        $this->loader = new \Twig_Loader_Filesystem($path);
        $this->twig = new \Twig_Environment($this->loader, []);
    }

    public function addPath($namespace, $path = null)
    {
        $this->loader->addPath($path, $namespace);
    }

    public function render($view, array $params = [])
    {
        return $this->twig->render($view . '.twig', $params);
    }

    public function addGlobal($key, $value)
    {
        $this->twig->addGlobal($key, $value);
    }
}
