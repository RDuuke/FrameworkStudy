<?php
namespace App\Blog;

use App\Blog\Actions\BlogAction;
use Framework\Module;
use Framework\Renderer;
use Framework\Router;

class BlogModule extends Module
{
    const DEFINITIONS = __DIR__ . DS . 'config.php';

    public function __construct($prefix, Router $route, Renderer\RendererInterface $renderer)
    {
        $renderer->addPath('home', __DIR__ . '/views');
        $route->get($prefix, BlogAction::class, 'blog.index');
        $route->get($prefix .'/{slug:[a-z\-0-9]+}', BlogAction::class, 'blog.show');
    }
}
