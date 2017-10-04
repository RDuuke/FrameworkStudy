<?php
namespace Framework\Renderer;

interface RendererInterface
{
    public function addPath($namespace, $path = null);

    public function render($view, array $params = []);

    public function addGlobal($key, $value);
}
