<?php

namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Email;
use App\Domain\Exception\InvalidEmailException;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testShouldCreateValidEmail(): void
    {
        $email = Email::fromString('test@example.com');
        
        $this->assertEquals('test@example.com', $email->value());
    }

    public function testShouldThrowExceptionOnInvalidEmail(): void
    {
        $this->expectException(InvalidEmailException::class);
        
        Email::fromString('invalid-email');
    }
}
