<?php

declare(strict_types=1);

namespace Eskimo;

use ErrorException;

class Router
{
    /**
     * @var array Array of all Routes 
     */
    private array $routes = [];

    /**
     * @var array Routes that have name
     */
    private array $namedRoutes = [];

    
    /**
     * @param string $basePah Base Path of URL
     */
    public function __construct(
        public string $basePath = '/'    
    ){}

    /**
     * @param string $method HTTP Methods GET,POST,PATCH,PUT,DELETE,HEAD,OPTIONS
     * @param string $path path of URL for 
     * @param callable|array $callback can be a callback function or array with object data [$obj::class, method] 
     * @param null|string $name Name of Route , It`s optional 
     */
    public function add(string $method, string $path, callable|array $callback, string $name = null)
    {
        $this->routes[] = [$method, $path, $callback];

        if ($name) {
            if (array_key_exists($name, $this->namedRoutes)) {
                throw new ErrorException("Name must be unique");
            }
            $this->namedRoutes[$name] = $path;
        }
    }

    /**
     * Get Matches from URL
     * @return void
     */
    public static function run(): void
    {
        
    }

    /**
     * @return string path Generator
     */
    public function create(string $name, ?array $params): string
    {
        return "test";
    }
}