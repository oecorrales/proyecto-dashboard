<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Password;
use App\Domain\Exception\WeakPasswordException;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    public function testShouldCreateValidPassword(): void
    {
        $password = Password::fromPlainText('Test123!@#');
        
        $this->assertNotEmpty($password->value());
    }

    public function testShouldThrowExceptionOnWeakPassword(): void
    {
        $this->expectException(WeakPasswordException::class);
        
        Password::fromPlainText('weak');
    }
}
