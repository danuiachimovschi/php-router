<?php

use Eskimo\Router;
use Demo\HomePage;

require __DIR__ . '/vendor/autoload.php';

$router = new Router();

$router->add('GET', '/', function(){
    dump("Dsd");
});

$router->add('GET|POST', '/projects', function(){
    dump('/projects');
});

$router->add('GET', '/tag/{*}/{*}/{*}', function($ion, $danu, $ser){
    dump($ion, $danu, $ser);
});

$router->add('GET', '/tag/{0-9}', function(){
    dump('tag/0-9');
});

$router->add('GET', '/home/{*}', [HomePage::class, 'getDanu']);

$router->run();
