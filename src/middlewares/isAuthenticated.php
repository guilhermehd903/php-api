<?php


namespace Service\Api\middlewares;

use Exception;
use Service\Api\core\JWT;
use Service\Api\Core\Request;

final class isAuthenticated{

    public function __construct(Request $req){
        $jwt = $req->headers["Authorization"];
        [$authType, $authHash] = explode(" ", $jwt);

        if($authType != "Bearer"){
            throw new Exception("Tipo de autenticação invalido!");    
        }

        $jwt = (new JWT())->decode($authHash);
        $req->user = (object) $jwt;
    }
}