<?php

use Service\Api\core\Init;
use Service\Api\core\Response;

include './vendor/autoload.php';
include './src/core/CORS.php';
include './src/core/Env.php';
include './src/core/Routes.php';
include './src/utils/General.php';

try {
    (new Init())->run($router);
} catch (Throwable $e) {
    $resp = new Response();

    $resp
        ->data([])
        ->error($e->getMessage())
        ->json();
}
