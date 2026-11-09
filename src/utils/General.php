<?php

function routeToRegex(string $route): string
{
    $route = rtrim($route, '/');

    return '#^' . preg_replace_callback(
        '#:([a-zA-Z_][a-zA-Z0-9_]*)#',
        fn($m) => '(?<' . $m[1] . '>[^/]+)',
        $route
    ) . '$#';
}

function request_method(): string
{
    return $_SERVER['REQUEST_METHOD'];
}

function request_uri(): string
{
    $urlChunk = explode("url=", $_SERVER["QUERY_STRING"]);
    return "/{$urlChunk[1]}";
}

function create_password(string $password): string|false
{
    if (strlen($password) < 8) return false;
    if (
        preg_match('/^[A-Za-z]+$/', $password) ||
        preg_match('/^\d+$/', $password) ||
        !preg_match('/^[A-Za-z\d]+$/', $password)
    ) return false;

    return password_hash($password, PASSWORD_DEFAULT);
}

function validade_password(string $password, string $hash): string|false
{
    return password_verify($password, $hash);
}

function filterNullValues(array|object $arr): array
{
    return array_filter((array) $arr, fn($value) => $value != null);
}
