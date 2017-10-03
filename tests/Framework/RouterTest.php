<?php
namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $request = new ServerRequest('GET', '/home');
        $this->router->get('/home', function () { return 'hello'; }, 'home');
        $route = $this->router->match($request);
        $this->assertEquals('home', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }

    public function testGetMethodIfDoesNotExists()
    {
        $request = new ServerRequest('GET', '/home');
        $this->router->get('/noexists', function () { return 'hello'; }, 'home');
        $route = $this->router->match($request);
        $this->assertEquals(null, $route);
    }

    public function testGetMethodWithParameters()
    {
        $request = new ServerRequest('GET', '/home/my-slug-8');
        $this->router->get('/home', function () { return 'asdfgh'; }, 'posts');
        $this->router->get('/home/{slug:[a-z0-9\-]+}-{id:\d+}', function () { return 'hello'; }, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals(['slug' => 'my-slug', 'id' => '8'], $route->getParams());

        // Test invalid url

        $route = $this->router->match(new ServerRequest('GET', '/home/my_article-8'));
        $this->assertEquals(null, $route);
    }

    public function testGenerateUri()
    {
        $this->router->get('/home', function () { return 'asdfgh'; }, 'posts');
        $this->router->get('/home/{slug:[a-z0-9\-]+}-{id:\d+}', function () { return 'hello'; }, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'my-article', 'id' => '8']);
        $this->assertEquals('/home/my-article-8', $uri);
    }


}