<?php

namespace Service\Api\tools;

use Service\Api\core\API;

class ClaudeAI
{
    private API $instance;
    private string $token;
    private string $version = "2023-06-01"; // anthropic-version
    private array $messages = [];
    private ?string $system = null;

    public function __construct()
    {
        $this->token = $_ENV["ANTHROPIC_API_KEY"];
    }

    public function text(): ClaudeAI
    {
        $this->instance = (new API('https://api.anthropic.com/v1/messages'))
            ->method("POST")
            ->head("Content-Type", "application/json")
            ->head("x-api-key", $this->token)
            ->head("anthropic-version", $this->version);

        return $this;
    }

    public function setSystem(string $content): ClaudeAI
    {
        $this->system = $content;
        return $this;
    }

    public function setMessage(string $role, string $content): ClaudeAI
    {
        if ($role === "system") {
            return $this->setSystem($content);
        }

        $this->messages[] = [
            "role" => $role,
            "content" => $content
        ];

        return $this;
    }

    public function setModel(string $value): ClaudeAI
    {
        $this->instance->body("model", $value);
        return $this;
    }

    public function setMaxToken(int $value): ClaudeAI
    {
        $this->instance->body("max_tokens", $value);
        return $this;
    }

    public function setTemp(float $value): ClaudeAI
    {
        $this->instance->body("temperature", $value);
        return $this;
    }

    public function setThinking(int $budgetTokens): ClaudeAI
    {
        $this->instance->body("thinking", [
            "type" => "enabled",
            "budget_tokens" => $budgetTokens
        ]);
        return $this;
    }

    public function send()
    {
        if ($this->system !== null) {
            $this->instance->body("system", $this->system);
        }

        $this->instance->body("messages", $this->messages);

        return $this->instance->exec();
    }
}