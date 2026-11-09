<?php

namespace Service\Api\tools;

use Service\Api\core\API;

enum Types
{
    case TEXT;
    case IMAGE;
}

class OpenAI
{
    private API $instance;
    private string $token;
    private array $messages = [];
    private string $type;

    public function __construct()
    {
        $this->token = $_ENV["OPEN_AI_KEY"];
    }

    public function text(): OpenAI
    {
        $this->instance = (new API('https://api.openai.com/v1/chat/completions'))
            ->method("POST")
            ->head("Content-Type", "application/json")
            ->head("Authorization", "Bearer {$this->token}")
            ->body("response_format", ['type' => 'json_object']);

        $this->type = "chat";
        return $this;
    }

    public function responseAPI(): OpenAI
    {
        $this->instance = (new API('https://api.openai.com/v1/responses'))
            ->method("POST")
            ->head("Content-Type", "application/json")
            ->head("Authorization", "Bearer {$this->token}")
            ->body("text", [
                'verbosity' => 'low',
                'format' => [
                    'type' => 'json_object',
                ],
            ]);
        $this->type = "api";
        return $this;
    }

    public function setMessage(string $role, string $content)
    {
        $this->messages[] = [
            "role" => $role,
            "content" => $content
        ];

        return $this;
    }

    public function setModel(string $value)
    {
        $this->instance->body("model", $value);
        return $this;
    }

    public function setEffort(mixed $value)
    {
        $this->instance->body("reasoning", $value);
        return $this;
    }

    public function setMaxToken(int $value)
    {
        $this->instance->body(($this->type == "api") ? "max_output_tokens" : "max_completion_tokens", $value);
        return $this;
    }

    public function setTemp(float $value)
    {
        $this->instance->body("temperature", $value);
        return $this;
    }

    public function send()
    {
        $this->instance->body(($this->type == "api") ? "input" : "messages", $this->messages);

        return $this->instance->exec();
    }
}
