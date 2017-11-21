<?php
namespace Framework\Actions;

use GuzzleHttp\Psr7\Response;

trait RouterAwareAction
{
    /**
     * @param $path
     * @param array $params
     * @return \GuzzleHttp\Psr7\MessageTrait|static
     */
    public function redirect($path, array $params = [])
    {
        $redirectUri = $this->router->generateUri($path,$params);
        return (new Response())
            ->withStatus(301)
            ->withHeader('location', $redirectUri);
    }
}