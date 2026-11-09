<?php

namespace Service\Api\dto;

use Service\Api\dto\DTOUtilities;

final class UpdateUserDTO extends DTOUtilities
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $name,
        public readonly ?string $email,
    ) {
    }
}
