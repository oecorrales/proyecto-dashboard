<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\WeakPasswordException;

class Password
{
    private string $hashedPassword;

    public function __construct(string $password)
    {
        if (!preg_match("/(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}/", $password)) {
            throw new WeakPasswordException("La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.");
        }
        $this->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    }

    public function toString(): string
    {
        return $this->hashedPassword;
    }
}