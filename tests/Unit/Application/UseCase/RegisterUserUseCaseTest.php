<?php

namespace App\Tests\Unit\Application\UseCase;

use App\Application\DTO\RegisterUserRequest;
use App\Application\UseCase\RegisterUserUseCase;
use App\Domain\Entity\User;
use App\Domain\Event\EventDispatcherInterface;
use App\Domain\Event\UserRegisteredEvent;
use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\Email;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

final class RegisterUserUseCaseTest extends TestCase
{
    private UserRepositoryInterface $userRepository;
    private EventDispatcherInterface $eventDispatcher;
    private RegisterUserUseCase $useCase;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->useCase = new RegisterUserUseCase($this->userRepository, $this->eventDispatcher);
        $this->userName = 'John Doe';
        $this->userEmail = 'john@example.com';
        $this->userPassword = 'Test123!@#';
    }

    public function testShouldRegisterNewUser(): void
    {
        $request = new RegisterUserRequest(
            $this->userName,
            $this->userEmail,
            $this->userPassword
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn(null);

        $this->userRepository
            ->expects($this->once())
            ->method('save');

        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with($this->isInstanceOf(UserRegisteredEvent::class));

        $user = $this->useCase->execute($request);

        $this->assertEquals('john@example.com', $user->email()->value());
    }

    public function testShouldThrowExceptionWhenUserAlreadyExists(): void
    {


        $request = new RegisterUserRequest(
            $this->userName,
            $this->userEmail,
            $this->userPassword
        );

        $existingUser = User::create(
            $this->userName,
            $this->userEmail,
            $this->userPassword
        );

        $this->userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn($existingUser);

        $this->expectException(UserAlreadyExistsException::class);

        $this->useCase->execute($request);
    }
}
