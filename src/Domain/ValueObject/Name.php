<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidNameException;

class Name
{
    private string $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 3 || strlen($name) > 50) {
            throw new InvalidNameException("El nombre debe tener entre 3 y 50 caracteres.");
        }
        $this->name = $name;
    }

    public function toString(): string
    {
        return $this->name;
    }
}