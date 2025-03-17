<?php

namespace App\Domain\ValueObject;

use App\Domain\Exception\InvalidEmailException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class Email
{
    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $value;

    private function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException('Formato de correo electronico no valido');
        }
        $this->value = $email;
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public function value(): string
    {
        return $this->value;
    }
}
