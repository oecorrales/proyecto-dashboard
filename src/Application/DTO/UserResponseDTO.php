<?php

namespace App\Application\DTO;

use App\Domain\Entity\User;

final class UserResponseDTO
{
    private function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $email,
        private readonly string $createdAt
    ) {}

    public static function fromUser(User $user): self
    {
        return new self(
            $user->id()->toString(),
            $user->name()->value(),
            $user->email()->value(),
            $user->createdAt()->format('Y-m-d H:i:s')
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->createdAt
        ];
    }
}
