<?php

use Eskimo\Router;

// use Eskimo\Router;

require __DIR__ . '/vendor/autoload.php';

$router = new Router();

$router->add('GET', '/home', function(){
    dump('home');
});

$router->add('GET|POST', '/projects', function(){
    dump('projects');
});

$router->add('PATCH', '/tag/{*}/{*}/{*}', function(){
    dump('/danu/{*}/{*}');
});

$router->add('DELETE', '/tag/3232/sfdsfds/fsdfsdf', function(){
    dump('tag');
});

$router->add('DELETE', '/tag/{0-9}', function(){
    dump('tag/0-9');
});

$router->run();
