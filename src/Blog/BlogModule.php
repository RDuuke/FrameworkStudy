<?php
namespace App\Blog;

use Framework\Renderer;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

class BlogModule
{
    private $renderer;

    public function __construct(Router $route, Renderer\RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        $this->renderer->addPath('home', __DIR__ . '/views');

        $route->get('/home', [$this, 'index'], 'blog.index');
        $route->get('/home/{slug:[a-z\-0-9]+}', [$this, 'show'], 'blog.show');
    }

    public function index(ServerRequestInterface $request)
    {
        return $this->renderer->render('@home/index');
    }

    public function show(ServerRequestInterface $request)
    {
            return $this->renderer->render(
                '@home/show',
                ['slug' => $request->getAttribute('slug')]
            );
    }
}
