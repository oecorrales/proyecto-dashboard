<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Password;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * User Entity
 */
#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    #[ORM\GeneratedValue(strategy: "NONE")]
    protected UuidInterface $id;

    #[ORM\Embedded(class: Name::class)]
    private Name $name;

    #[ORM\Embedded(class: Email::class)]
    private Email $email;

    #[ORM\Embedded(class: Password::class)]
    private Password $password;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    private function __construct(
        UuidInterface $id,
        Name $name,
        Email $email,
        Password $password,
        DateTimeImmutable $createdAt
    ) {
        $this->id = $id ?? Uuid::uuid4();
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
    }

    public static function create(
        string $name,
        string $email,
        string $password
    ): self {
        return new self(
            Uuid::uuid4(),
            Name::fromString($name),
            Email::fromString($email),
            Password::fromPlainText($password),
            new DateTimeImmutable()
        );
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
