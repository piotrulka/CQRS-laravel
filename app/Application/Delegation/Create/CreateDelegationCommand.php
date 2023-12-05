<?php

namespace App\Application\Delegation\Create;

use App\Domain\Shared\Bus\Command;

class CreateDelegationCommand implements Command
{
    public function __construct(
        private string $country,
        private string $city,
        private string $start,
        private string $end,
        private int $userId,
        private int $amountDue,
    ) {
    }

    public function country(): string
    {
        return $this->country;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function start(): string
    {
        return $this->start;
    }

    public function end(): string
    {
        return $this->end;
    }

    public function userId(): int
    {
        return $this->userId;
    }

    public function amountDue(): int
    {
        return $this->amountDue;
    }
}
