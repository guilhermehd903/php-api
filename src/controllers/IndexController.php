<?php

namespace Service\Api\controllers;

use Service\Api\core\Request;
use Service\Api\core\Response;

class IndexController
{

    public function index(Request $req, Response $res)
    {
        $res
            ->data([])
            ->response("Pong!")
            ->json();
    }

    public function notFound(Request $req, Response $res)
    {
        $res
            ->data([])
            ->error("Route not found")
            ->json();
    }
}
