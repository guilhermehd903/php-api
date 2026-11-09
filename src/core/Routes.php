<?php

use Service\Api\core\Router;
use Service\Api\controllers\IndexController;
use Service\Api\controllers\UserController;
use Service\Api\middlewares\isAuthenticated;

$router = new Router();


/*[GET]*/
$router->notFound("/notfound", [IndexController::class, 'notFound']);
$router->get("/user/:id", [isAuthenticated::class], [UserController::class, 'getById']);

/*[POST]*/
$router->post("/user", [], [UserController::class, 'create']);

/*[PUT]*/
$router->put("/user/:id", [isAuthenticated::class], [UserController::class, 'update']);

/*[DELETE]*/
$router->delete("/user/:id", [isAuthenticated::class], [UserController::class, 'delete']);
