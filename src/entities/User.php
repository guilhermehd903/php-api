<?php

namespace Service\Api\entities;

final class User
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email
    ) {}

    public static function create(
        string $id,
        string $name,
        string $email
    ): self {
        return new self(
            $id,
            $name,
            $email
        );
    }
}
