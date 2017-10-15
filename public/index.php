<?php
require dirname(__DIR__)."/vendor/autoload.php";
use App\Blog\BlogModule;
use DI\ContainerBuilder;
use Framework\App;
define("DS", DIRECTORY_SEPARATOR);

$modules = [
    BlogModule::class
];
$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . DS . 'config' . DS . 'config.php');

foreach ($modules as $module) {
    if ($module::DEFINITIONS) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}
$container = $builder->build();
//$renderer = new \Framework\Renderer\PHPRenderer(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views');
//$renderer = new \Framework\Renderer\TwigRenderer(dirname(__DIR__) . DS . 'views');

$container->get(\Framework\Renderer\RendererInterface::class);

$app = new App(
    $container,
    $modules
    );
if (php_sapi_name() != 'cli') {
    $response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
    \Http\Response\send($response);
}

