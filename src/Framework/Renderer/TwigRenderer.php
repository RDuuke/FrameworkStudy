<?php

namespace Framework\Renderer;

use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigRenderer implements RendererInterface
{
    private $twig;
    private $loader;

    public function __construct(Twig_Loader_Filesystem $loader, Twig_Environment $twig)
    {
        $this->loader = $loader;
        $this->twig = $twig;
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
