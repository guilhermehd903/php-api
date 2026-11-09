<?php

namespace Service\Api\services;

use Exception;
use PDO;
use Service\Api\core\DB;
use Service\Api\dto\CreateUserDTO;
use Service\Api\dto\UpdateUserDTO;
use Service\Api\entities\User;

class MockService extends DB
{
    public function create(CreateUserDTO $dto): Exception|User
    {
        $insertStr = $dto->cleanToInsert();
        $columns = $dto->cleanToColumn();

        $stmt = self::con()->prepare('
            INSERT INTO users (' . $columns . ')
            VALUES (' . $insertStr . ')
            RETURNING id
        ');

        $stmt->execute($dto->cleanFields());
        $id = $stmt->fetchColumn();

        return $this->findById($id);
    }

    public function findById(string $id): User
    {
        $stmt = self::con()->prepare('
            SELECT * FROM "users" WHERE id = :id
        ');

        $stmt->execute([
            'id' => $id,
        ]);

        $data = $stmt->fetch();

        return $this->row($data);
    }

    public function update(UpdateUserDTO $dto): User
    {
        $updateStr = $dto->cleanToUpdate();

        $stmt = self::con()->prepare('UPDATE "users" SET ' . $updateStr . ' WHERE id = :id');

        $stmt->execute($dto->cleanFields());

        return $this->findById($dto->id);
    }

    public function delete(string $id): bool
    {
        $stmt = self::con()->prepare('DELETE FROM "users" WHERE id = :id');

        return $stmt->execute([
            "id" => $id
        ]);
    }

    public function findAll(): array
    {
        $stmt = self::con()->prepare('
            SELECT * FROM "users"
        ');

        $stmt->execute();

        $data = $stmt->fetchAll();

        return \array_map(
            fn($n) =>
            $this->row($n),
            $data
        );
    }

    private function row(object $data): User
    {
        return User::create(
            id: $data->id,
            name: $data->name,
            email: $data->email
        );
    }
}
