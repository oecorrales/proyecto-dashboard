<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidEmailException;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException("El correo electrónico no es válido.");
        }
        $this->email = $email;
    }

    public function toString(): string
    {
        return $this->email;
    }
}