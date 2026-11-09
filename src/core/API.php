<?php

namespace Service\Api\core;

use Exception;

class API
{
    private \CurlHandle $ch;
    private string $url;
    private string $method = "GET";
    private array $body;
    private array $head;

    public function __construct(string $url)
    {
        $this->ch = curl_init();
        $this->url = $url;
    }

    public function method(string $value): API
    {
        $this->method = $value;
        return $this;
    }

    public function body(string $key, mixed $value): API
    {
        $this->body[$key] = $value;
        return $this;
    }

    public function head(string $key, string $value): API
    {
        $this->head[] = "{$key}: {$value}";
        return $this;
    }

    public function exec(): mixed
    {
        $opt = [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 1800,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_HTTPHEADER => $this->head,
            CURLOPT_CUSTOMREQUEST => $this->method
        ];

        if ($this->method != "GET" && count($this->body) > 0) {
            $opt[CURLOPT_POSTFIELDS] = \json_encode($this->body);
        }

        curl_setopt_array($this->ch, $opt);

        $response = curl_exec($this->ch);

        if (curl_errno($this->ch)) {
            return curl_error($this->ch);
        } else {
            return (array)\json_decode($response);
        }
    }
}
