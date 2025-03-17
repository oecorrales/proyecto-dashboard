<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findById(UuidInterface $id): ?User;
    public function findByEmail(Email $email): ?User;
    public function delete(UuidInterface $id): void;
}
