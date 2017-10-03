<?php
namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;

class App
{

    public function run(ServerRequestInterface $request)
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && substr($uri, -1) === "/") {
            $response = (new Response())
                        ->withStatus(301)
                        ->withHeader('Location', substr($uri, 0, -1));
            return $response;
        }
        if ($uri === '/home') {
            return new Response(200, [], "<h1>Welcome to home</h1>");
        }
        return new Response(404, [], "<h1>Error 404</h1>");
    }
}
