<?php

use Eskimo\Router;

require __DIR__ . '/vendor/autoload.php';

$router = new Router();

$router->add('GET', '/home', function(){
    return 'danu';
});

$router->add('GET|POST', '/projects', function(){
    return 'danu';
});

$router->add('PATCH', '/project/{id}', function(){
    return 'danu';
});

$router->add('DELETE', '/tag/{id}', function(){
    return 'danu';
});

$router->run();
