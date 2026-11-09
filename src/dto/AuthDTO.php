<?php

namespace Service\Api\dto;

final class AuthDTO
{

    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Informe um e-mail valido!');
        }
    }
}
