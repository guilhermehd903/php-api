<?php

namespace Service\Api\dto;

use Service\Api\dto\DTOUtilities;

final class CreateUserDTO extends DTOUtilities
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
    ) {
    }
}
