<?php

declare(strict_types=1);

namespace Eskimo;

use ErrorException;

/**
 * Router Class
 * @author Iachimovschi Daniel
 */
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

    public const REGEX = [
        'a-z*' => 'a-zA-Z',
        '0-9' => '0-9',
        '*' => '\s\S'
    ];

    /**
     * Crate Route Path 
     * @param string $method HTTP Methods GET,POST,PATCH,PUT,DELETE,HEAD,OPTIONS
     * @param string $path path of URL for 
     * @param callable|array $callback can be a callback function or array with object data [$obj::class, method] 
     * @param null|string $name Name of Route , It`s optional 
     */
    public function add(string $method, string $path, callable|array $callback, string $name = null)
    {
        $this->routes[] = [
            'methods' =>$method, 
            'pattern' => $path, 
            'action' => $callback
        ];

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
    public function run(): mixed
    {
        if ($this->routes) {
            foreach($this->routes as $router){
                extract($router);
                $httpMethodAllowed = explode("|", $methods);
                $httpAllowed = false;

                foreach($httpMethodAllowed as $httpM)
                {
                    if ($httpM === $this->getCurrentRequestMethod()) {
                        $httpAllowed = true;
                    }
                } 
                if (!$httpAllowed) die("HTTP does not allow");


                $regexPattern = $this->pathToRegex($pattern);

                if (preg_match($regexPattern, $this->getCurrentUrl())) {
                    $matchesUrl = preg_match_all($regexPattern, $this->getCurrentUrl(), $arguments,PREG_SET_ORDER);

                    if ($matchesUrl) {
                        $arguments = $arguments[0];
                        unset($arguments[0]);
                    }

                    if (is_callable($action) && $httpAllowed){
                        if (count($arguments)) {
                            return $action(...$arguments);   
                        }
                        return $action();
                    }

                    if (is_array($action)) {
                        if (class_exists($action[0])) {
                            if (method_exists(...$action))
                            {
                                return call_user_func(
                                    [new $action[0], $action[1]], 
                                    ...$arguments, 
                                );
                            }
                            die("This method of Object doesn`t Exist");
                        }
                        die("This Object doesn`t Exist");
                    }
                }
            }
            die("Routes does not match with current url");
        }
        die("Routes does not register");
    }

    /**
     * @return string path Generator
     */
    public function create(string $name, ?array $params): string
    {
        return "test";
    }

    /**
     * @return string Current HTTP Url
     */
    public function getCurrentUrl(): string
    {
        return rtrim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
    }

    /**
     * @return string Return Regex Expresion For Matching
     */
    public function pathToRegex($router): string
    {
        if (preg_match("/\/{(?P<filter>[\s\S]+)}/i", $router)) {
            $router = preg_replace("/\/{(.*?)}/i", "/(.*?)", $router);
        }
        return "/^" .str_replace('/', '\/', $router) ."$/";
    }

    /**
     * @return string Return Current Request Method
     */
    public function getCurrentRequestMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}