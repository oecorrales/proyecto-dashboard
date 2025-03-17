<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\Email;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function save(User $user): void
    {
        if (empty($user->id())) {
            throw new RuntimeException("User ID is missing before persisting.");
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById(UuidInterface $id): ?User
    {
        return $this->entityManager->find(User::class, $id);
    }

    public function findByEmail(Email $email): ?User
    {
        return $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email.value = :email')
            ->setParameter('email', $email->value())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function delete(UuidInterface $id): void
    {
        $user = $this->findById($id);
        if ($user !== null) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }
    }
}
