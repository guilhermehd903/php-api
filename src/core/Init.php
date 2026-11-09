<?php

namespace Service\Api\core;

use Exception;

class Init
{

    public function run(Router $router)
    {
        $method = request_method();
        $uri = request_uri();

        foreach ($router->list($method) as $endpoint => $item) {
            $regex = routeToRegex($endpoint);

            if (preg_match($regex, $uri, $matches)) {
                $middlewares = $item["middlewares"];
                $controller = $item["action"];

                $params = array_filter(
                    $matches,
                    fn($k) => !is_int($k),
                    ARRAY_FILTER_USE_KEY
                );

                $class = $controller[0];
                $action = $controller[1];
            }
        }

        $request = new Request(
            method: $method,
            uri: $uri,
            params: (object) $params
        );

        $response = new Response();

        if ($class && $action) {
            try {
                //execute all middlewares
                if (count($middlewares) > 0) {
                    foreach ($middlewares as $middl) {
                        (new $middl($request));
                    }
                }

                return (new $class())->$action($request, $response);
            } catch (Exception $e) {
                $response
                    ->data([])
                    ->error($e->getMessage())
                    ->json();
            }
        }

        $notFound = $router->list('404');

        if (!$notFound) return null;

        $notFoundKey = array_key_first($router->list('404'));

        $notFoundClass = $notFound[$notFoundKey][0];
        $notFoundAction = $notFound[$notFoundKey][1];

        return (new $notFoundClass())->$notFoundAction($request, $response);
    }
}
