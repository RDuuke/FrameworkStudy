<?php

use App\Blog\BlogModule;

return [
    'blog.prefix' => '/home',
    BlogModule::class => \DI\object()->constructorParameter('prefix', \DI\get('blog.prefix'))
];
