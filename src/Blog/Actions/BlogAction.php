<?php
namespace App\Blog\Actions;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogAction
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    public function __construct(RendererInterface $renderer)
    {

        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $slug = $request->getAttribute('slug');
        if ($slug) {
            return $this->show($slug);
        }
        return $this->index();
    }

    public function index()
    {
        return $this->renderer->render('@home/index');
    }

    public function show($slug)
    {
        return $this->renderer->render(
            '@home/show',
            ['slug' => $slug]
        );
    }
}
