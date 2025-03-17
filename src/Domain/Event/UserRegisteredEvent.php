<?php

namespace App\Domain\Event;

use App\Domain\Entity\User;

final class UserRegisteredEvent
{
    public function __construct(
        private readonly User $user
    ) {}

    public function user(): User
    {
        return $this->user;
    }
}
