<?php

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

#[ORM\Embeddable]
final class Name
{
    #[ORM\Column(type: 'string', length: 255)]
    private string $value;

    private function __construct(string $name)
    {
        if (strlen($name) < 2) {
            throw new InvalidArgumentException('El nombre debe contener al menos dos caracteres');
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
            throw new InvalidArgumentException('El nombre solo debe contener letras y espacios');
        }

        $this->value = $name;
    }

    public static function fromString(string $name): self
    {
        return new self($name);
    }

    public function value(): string
    {
        return $this->value;
    }
}
