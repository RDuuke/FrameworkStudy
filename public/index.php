<?php
require "../vendor/autoload.php";
use App\Blog\BlogModule;
use Framework\App;
$app = new App([BlogModule::class]);
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());
\Http\Response\send($response);
