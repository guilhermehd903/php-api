<?php

namespace Service\Api\controllers;

use Exception;
use Service\Api\core\Request;
use Service\Api\core\Response;
use Service\Api\data\Mock;

class UserController
{

    public function create(Request $req, Response $res)
    {
        $res
            ->data([])
            ->response("User created")
            ->json();
    }

    public function update(Request $req, Response $res)
    {
        $res
            ->data([])
            ->response("User updated")
            ->json();
    }

    public function getById(Request $req, Response $res)
    {
        $id = $req->params->id;
        $user = \array_filter(Mock::Users, fn($value) => $value["id"] == $id);

        if(!$user){
            throw new Exception("User not found");
        }

        $res
            ->data($user[0])
            ->response("Usuário recuperado com sucesso!")
            ->json();
    }

    public function getAll(Request $req, Response $res)
    {
        $res
            ->data(Mock::Users)
            ->response("Usuário recuperados com sucesso!")
            ->json();
    }
}
