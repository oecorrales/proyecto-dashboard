<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\DTO\RegisterUserRequest;
use App\Application\DTO\UserResponseDTO;
use App\Application\UseCase\RegisterUserUseCase;
use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Exception\InvalidEmailException;
use App\Domain\Exception\WeakPasswordException;

final class RegisterUserController
{
    public function __construct(
        private readonly RegisterUserUseCase $registerUserUseCase
    ) {}

    public function __invoke(array $request): array
    {
        try {
            if (!isset($request['body'])) {
                return [
                    'statusCode' => 400,
                    'data' => ['error' => 'Invalid request data']
                ];
            }

            $data = $request['body'];
            $registerUserRequest = new RegisterUserRequest(
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['password'] ?? ''
            );

            $user = $this->registerUserUseCase->execute($registerUserRequest);
            
            return [
                'statusCode' => 201,
                'data' => UserResponseDTO::fromUser($user)->toArray()
            ];

        } catch (UserAlreadyExistsException $e) {
            return [
                'statusCode' => 409,
                'data' => ['error' => $e->getMessage()]
            ];
        } catch (InvalidEmailException | WeakPasswordException $e) {
            return [
                'statusCode' => 400,
                'data' => ['error' => $e->getMessage()]
            ];
        }
    }
}
