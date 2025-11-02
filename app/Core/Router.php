<?php

namespace App\Core;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public static function load($file)
    {
        $router = new static;
        require $file;
        return $router;
    }

    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    public function dispatch($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        // Handle dynamic routes with parameters
        foreach ($this->routes[$requestType] as $route => $controller) {
            // Convert route to regex: /users/{id} -> /users/(\w+)
            $pattern = preg_replace('/\\\{[a-zA-Z0-9_]+\\\}/', '([a-zA-Z0-9_]+)', preg_quote($route, '/'));
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // remove the full match
                list($controller, $method) = explode('@', $controller);
                return $this->callAction($controller, $method, $matches);
            }
        }

        return $this->handleNotFound();
    }

    protected function callAction($controller, $action, $params = [])
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new \Exception("{$controller} does not respond to the {$action} action.");
        }

        return $controller->$action(...$params);
    }

    protected function handleNotFound()
    {
        http_response_code(404);
        // In a real app, you would render a beautiful 404 page.
        require_once dirname(__DIR__) . '/../templates/errors/404.php';
        exit();
    }
}
