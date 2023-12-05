<?php

declare(strict_types=1);

namespace App\Domain\Delegation\Aggregate;

use App\Domain\Delegation\ValueObject\AmountDue;
use App\Domain\Delegation\ValueObject\Country;
use App\Domain\Delegation\ValueObject\Id;
use App\Domain\Delegation\ValueObject\UserId;
use App\Domain\Shared\ValueObject\DateTimeValueObject;

final class Delegation
{
    private function __construct(
        private Id $id,
        private Country $country,
        private AmountDue $amountDue,
        private UserId $userId,
        private DateTimeValueObject $start,
        private DateTimeValueObject $end,
        private DateTimeValueObject $createdAt,
        private ?DateTimeValueObject $updatedAt,
    ) {
    }

    public static function create(
        Id $id,
        Country $country,
        AmountDue $amountDue,
        UserId $userId,
        DateTimeValueObject $start,
        DateTimeValueObject $end,
        DateTimeValueObject $createdAt,
        ?DateTimeValueObject $updatedAt = null,
    ): self {
        return new self(
            $id,
            $country,
            $amountDue,
            $userId,
            $start,
            $end,
            $createdAt,
            $updatedAt,
        );
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function country(): Country
    {
        return $this->country;
    }

    public function amountDue(): AmountDue
    {
        return $this->amountDue;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function start(): DateTimeValueObject
    {
        return $this->start;
    }

    public function end(): DateTimeValueObject
    {
        return $this->end;
    }

    public function createdAt(): DateTimeValueObject
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updatedAt;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'country' => $this->country()->value(),
            'amount_due' => $this->amountDue()->value(),
            'user_id' => $this->userId()->value(),
            'start' => $this->start()->value(),
            'end' => $this->end()->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value(),
        ];
    }
}
