<?php
namespace App\Blog;

use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

class BlogModule
{
    public function __construct(Router $route)
    {
        $route->get('/home', [$this, 'index'], 'blog.index');
        $route->get('/home/{slug:[a-z\-]+}', [$this, 'show'], 'blog.show');
    }

    public function index(ServerRequestInterface $request)
    {
        return '<h1>Welcome to home</h1>';
    }

    public function show(ServerRequestInterface $request)
    {
            return '<h1>Welcome to article '.$request->getAttribute('slug').'</h1>';
    }
}
