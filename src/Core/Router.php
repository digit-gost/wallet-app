<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get($uri, $action)
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function post($uri, $action)
    {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $action = $this->routes[$method][$uri] ?? null;

        if (!$action) {
            echo "404";
            return;
        }

        [$controller, $methodAction] = explode('@', $action);

        $class = "App\\Controllers\\$controller";
        (new $class())->$methodAction();
    }
}