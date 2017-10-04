<?php
require "../vendor/autoload.php";
use App\Blog\BlogModule;
use Framework\App;

//$renderer = new \Framework\Renderer\PHPRenderer(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');
$renderer = new \Framework\Renderer\TwigRenderer(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');

$app = new App(
    [BlogModule::class],
    [
        'renderer' => $renderer
    ]
    );
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);
