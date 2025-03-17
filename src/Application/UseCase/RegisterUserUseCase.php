<?php

namespace App\Application\UseCase;

use App\Application\DTO\RegisterUserRequest;
use App\Domain\Entity\User;
use App\Domain\Event\EventDispatcherInterface;
use App\Domain\Event\UserRegisteredEvent;
use App\Domain\Repository\UserRepositoryInterface;
use App\Domain\ValueObject\Email;
use App\Domain\Exception\UserAlreadyExistsException;

final class RegisterUserUseCase
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function execute(RegisterUserRequest $request): User
    {
        $email = Email::fromString($request->email());
        
        if ($this->userRepository->findByEmail($email) !== null) {
            throw new UserAlreadyExistsException('Usuario con ese correo ya existe');
        }

        $user = User::create(
            $request->name(),
            $request->email(),
            $request->password()
        );

        $this->userRepository->save($user);
        
        $this->eventDispatcher->dispatch(new UserRegisteredEvent($user));

        return $user;
    }
}
