<?php

namespace App\Application\DTO;

final class RegisterUserRequest
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $password
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
