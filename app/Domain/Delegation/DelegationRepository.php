<?php

declare(strict_types=1);

namespace App\Domain\Delegation;

use App\Domain\Delegation\Aggregate\Delegation;
use App\Domain\Delegation\Exception\DelegationNotFoundException;
use App\Domain\Delegation\ValueObject\Id;

interface DelegationRepository
{
    public function create(Delegation $delegation): void;

    public function update(Delegation $delegation): void;

    /**
     * @throws DelegationNotFoundException
     */
    public function findById(Id $delegationId): Delegation;

    public function searchById(Id $delegationId): ?Delegation;

    public function searchByCriteria(DelegationSearchCriteria $criteria): array;

    public function delete(Delegation $delegationId): void;
}
