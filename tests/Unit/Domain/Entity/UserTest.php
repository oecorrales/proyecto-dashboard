<?php

namespace App\Tests\Unit\Domain\Entity;

use App\Domain\Entity\User;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class UserTest extends TestCase
{
    public function testShouldCreateUser(): void
    {
        $user = User::create(
            'John Doe',
            'john@example.com',
            'Test123!@#'
        );

        $this->assertNotEmpty($user->id()->toString());
        $this->assertEquals('John Doe', $user->name()->value());
        $this->assertEquals('john@example.com', $user->email()->value());
        $this->assertInstanceOf(DateTimeImmutable::class, $user->createdAt());
    }
}
