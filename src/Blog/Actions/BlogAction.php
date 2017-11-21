<?php
namespace App\Blog\Actions;

use App\Blog\Table\PostTable;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var Router
     */
    private $router;
    /**
     * @var PostTable
     */
    private $postTable;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {

        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        }
        return $this->index();
    }

    public function index()
    {
        $posts = $this->postTable->findPaginated();
        return $this->renderer->render('@home/index', compact('posts'));
    }

    /**
     * @param ServerRequestInterface $request
     * @return \GuzzleHttp\Psr7\MessageTrait|static
     */
    public function show(ServerRequestInterface $request)
    {
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($request->getAttribute('id'));
        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
                'slug' => $post->slug,
                'id' => $post->id
            ]);
        }
        return $this->renderer->render(
            '@home/show',
            ['post' => $post]
        );
    }
}
