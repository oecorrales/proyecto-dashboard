<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\UserId;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Password;
use DateTimeImmutable;

class User
{
    private UserId $id;
    private Name $name;
    private Email $email;
    private Password $password;
    private DateTimeImmutable $createdAt;

    public function __construct(UserId $id, Name $name, Email $email, Password $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = new DateTimeImmutable();
    }

    public function id(): UserId { return $this->id; }
    public function name(): Name { return $this->name; }
    public function email(): Email { return $this->email; }
    public function password(): Password { return $this->password; }
    public function createdAt(): DateTimeImmutable { return $this->createdAt; }
}