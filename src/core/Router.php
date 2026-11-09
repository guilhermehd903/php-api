<?php

namespace Service\Api\core;

class Router
{

    private $routes;

    public function list(string $method){
        $lowerMethod = strtolower($method);

        if(!in_array($lowerMethod, ["get", "post", "put", "delete", "404"])){
            return null;
        }

        return $this->routes[$lowerMethod];
    }

    public function get($endpoint, $middleware = [], $action)
    {
        if (!isset($this->routes["get"][$endpoint])) {
            $this->routes["get"][$endpoint]["action"] = $action;
            $this->routes["get"][$endpoint]["middlewares"] = $middleware;
        }
    }

    public function post($endpoint, $middleware = [], $action)
    {
        if (!isset($this->routes["post"][$endpoint])) {
            $this->routes["post"][$endpoint]["action"] = $action;
            $this->routes["post"][$endpoint]["middlewares"] = $middleware;
        }
    }

    public function put($endpoint, $middleware = [], $action)
    {
        if (!isset($this->routes["put"][$endpoint])) {
            $this->routes["put"][$endpoint]["action"] = $action;
            $this->routes["put"][$endpoint]["middlewares"] = $middleware;
        }
    }

    public function delete($endpoint, $middleware = [], $action)
    {
        if (!isset($this->routes["delete"][$endpoint])) {
            $this->routes["delete"][$endpoint]["action"] = $action;
            $this->routes["delete"][$endpoint]["middlewares"] = $middleware;
        }
    }

    public function notFound($endpoint, $action)
    {
        if (!isset($this->routes["404"][$endpoint])) {
            $this->routes["404"][$endpoint] = $action;
        }
    }
}
