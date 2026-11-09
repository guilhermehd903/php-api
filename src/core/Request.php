<?php

namespace Service\Api\Core;

use stdClass;

final class Request
{
    public readonly string $method;
    public readonly string $uri;
    public readonly stdClass $params;
    public readonly array $query;
    public readonly stdClass $body;
    public readonly array $headers;
    public array $atributes;

    public function __construct(
        string $method,
        string $uri,
        ?stdClass $params = null
    ) {
        $this->method  = strtoupper($method);
        $this->uri     = $uri;
        $this->params  = $params ?? new stdClass();
        $this->query   = $_GET;
        $this->headers = getallheaders();

        $this->body = $this->parseBody();
    }

    private function parseBody(): stdClass
    {
        $raw = file_get_contents('php://input');

        if (!$raw) {
            return new stdClass();
        }

        $contentType = $this->headers['Content-Type'] ?? '';

        if (str_contains($contentType, 'application/json')) {
            return json_decode($raw, false) ?? new stdClass();
        }

        return (object) $_POST;
    }

    public function __set(string $name, $value): void
    {
        $this->atributes[$name] = $value;
    }

    public function __get(string $name): mixed
    {
        if(!isset($this->atributes[$name])) return null;
        
        return $this->atributes[$name];
    }
}
