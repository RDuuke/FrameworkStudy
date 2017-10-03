<?php
namespace Tests\Framework;

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Modules\ErrorsModule;
use Tests\Framework\Modules\StringModule;

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
        $app = new App([
            BlogModule::class
        ]);
        $request = new ServerRequest('GET', '/home');
        $response = $app->run($request);
        $this->assertContains('<h1>Welcome to home</h1>', (string)$response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
        $requestSingle = new ServerRequest('GET', '/home/article-of-test');
        $responseSingle = $app->run($requestSingle);
        $this->assertEquals('<h1>Welcome to article article-of-test</h1>', (string)$responseSingle->getBody());
    }

    public function testThrowExceptionIfNoResponseSent()
    {
        $app = new App([
            ErrorsModule::class
        ]);
        $request = new ServerRequest('GET', '/demo');
        $this->expectException(\Exception::class);
        $app->run($request);
    }

    public function testConvertStringToResponse()
    {
        $app = new App([
            StringModule::class
        ]);
        $request = new ServerRequest('GET', '/demo');
        $response = $app->run($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals("DEMO", (string)$response->getBody());
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