<?php


namespace App\Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Name;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    public function testShouldCreateValidName(): void
    {
        $name = Name::fromString('John Doe');
        
        $this->assertEquals('John Doe', $name->value());
    }

    public function testShouldThrowExceptionOnTooShortName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El nombre debe contener al menos dos caracteres');
        
        Name::fromString('J');
    }

    public function testShouldThrowExceptionOnInvalidCharacters(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('El nombre solo debe contener letras y espacios');
        
        Name::fromString('John123');
    }

    public function testShouldAcceptNameWithSpaces(): void
    {
        $name = Name::fromString('John Michael Doe');
        
        $this->assertEquals('John Michael Doe', $name->value());
    }
}