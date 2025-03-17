<?php

namespace App\Tests\Integration\Infrastructure\Persistence;

use App\Domain\Entity\User;
use App\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Persistence\Mapping\MappingException;
use PHPUnit\Framework\TestCase;

final class DoctrineUserRepositoryTest extends TestCase
{
    private EntityManager $entityManager;
    private DoctrineUserRepository $repository;

    protected function setUp(): void
    {
        $this->entityManager = require __DIR__ . '/../../../../config/doctrine.php';
        $this->repository = new DoctrineUserRepository($this->entityManager);

        // Create database schema
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);
        $this->userName = 'John Doe';
        $this->userEmail = 'john@example.com';
        $this->userPassword = 'Test123!@#';
    }

    public function testShouldSaveAndRetrieveUser(): void
    {
        $user = User::create(
            $this->userName,
            $this->userEmail,
            $this->userPassword
        );

        $this->repository->save($user);
        $this->entityManager->clear();

        $foundUser = $this->repository->findById($user->id());

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->id()->toString(), $foundUser->id()->toString());
        $this->assertEquals($user->email()->value(), $foundUser->email()->value());
    }

    public function testShouldFindUserByEmail(): void
    {
        $user = User::create(
            $this->userName,
            $this->userEmail,
            $this->userPassword
        );

        $this->repository->save($user);
        $this->entityManager->clear();

        $foundUser = $this->repository->findByEmail($user->email());

        $this->assertNotNull($foundUser);
        $this->assertEquals($user->email()->value(), $foundUser->email()->value());
    }

    /**
     * @throws MappingException
     */
    public function testShouldDeleteUser(): void
    {
        $user = User::create(
            $this->userName,
            $this->userEmail,
            $this->userPassword
        );

        $this->repository->save($user);
        $this->repository->delete($user->id());
        $this->entityManager->clear();

        $foundUser = $this->repository->findById($user->id());

        $this->assertNull($foundUser);
    }

    protected function tearDown(): void
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
    }
}