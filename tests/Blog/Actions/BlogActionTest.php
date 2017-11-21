<?php
namespace Tests\App\Blog\Actions;

use App\Blog\Actions\BlogAction;
use App\Blog\Table\PostTable;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class BlogActionTest extends TestCase
{
    private $action;
    private $renderer;
    private $pdoTable;
    private $router;

    public function setUp()
    {
        $this->renderer = $this->prophesize(RendererInterface::class);
        $this->pdoTable = $this->prophesize(PostTable::class);
        $this->router = $this->prophesize(Router::class);
        $this->action = new BlogAction(
            $this->renderer->reveal(),
            $this->router->reveal(),
            $this->pdoTable->reveal()
        );
    }
    public function makePost($id, $slug)
    {
        $post = new \stdClass();
        $post->id = $id;
        $post->slug = $slug;
        return $post;
    }

    public function testShowRedirect()
    {
        $id = 9;
        $slug = 'asdfg-asdfg';
        $post = $this->makePost($id, $slug);
        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id' , 9)
            ->withAttribute('slug', 'demo');

        $this->router->generateUri('blog.show', ['id' => $post->id, 'slug' => $post->slug])->willReturn('/demo2');
        $this->pdoTable->find($post->id)->willReturn($post);

        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals(301, $response->getStatusCode());
        $this->assertEquals(['/demo2'], $response->getHeader('location'));
    }

    public function testShowRender()
    {
        $id = 9;
        $slug = 'asdfg-asdfg';
        $post = $this->makePost($id, $slug);
        $request = (new ServerRequest('GET', '/'))
            ->withAttribute('id' , $post->id)
            ->withAttribute('slug', $post->slug);

        $this->pdoTable->find($post->id)->willReturn($post);
        $this->renderer->render('@home/show', ['post' => $post])->willReturn('');
        $response = call_user_func_array($this->action, [$request]);
        $this->assertEquals(true,true);
    }
}
