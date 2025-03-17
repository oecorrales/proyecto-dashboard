<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\WeakPasswordException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Password
{
    #[ORM\Column(type: 'string', length: 255)]
    private string $hashedValue;

    private function __construct(string $password)
    {
        if (!$this->isValidPassword($password)) {
            throw new WeakPasswordException('La contrasenha debe tener al menos 8 caracteres, una mayuscula, un numero y un caracter especial');
        }
        $this->hashedValue = password_hash($password, PASSWORD_ARGON2ID);
    }

    public static function fromPlainText(string $password): self
    {
        return new self($password);
    }

    private function isValidPassword(string $password): bool
    {
        return strlen($password) >= 8 &&
            preg_match('/[A-Z]/', $password) &&
            preg_match('/[0-9]/', $password) &&
            preg_match('/[^A-Za-z0-9]/', $password);
    }

    public function value(): string
    {
        return $this->hashedValue;
    }
}
