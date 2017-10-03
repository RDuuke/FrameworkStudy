<?php
namespace Tests\Framework;

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/demoslash/');
        $response = $app->run($request);

        $this->assertContains('/demoslash', $response->getHeader('Location'));
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testSaludo()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/home');
        $response = $app->run($request);
        $this->assertContains('<h1>Welcome to home</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testError404()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/demoError');
        $response = $app->run($request);
        $this->assertContains("<h1>Error 404</h1>", (string)$response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }


}