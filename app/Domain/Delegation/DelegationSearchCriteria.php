<?php

namespace App\Domain\Delegation;

use Hibit\Criteria;
use Hibit\CriteriaPagination;

class DelegationSearchCriteria extends Criteria
{
    public const PAGINATION_SIZE = 10;

    private ?string $country = null;
    private ?string $city = null;
    private ?string $start = null;
    private ?string $end = null;

    private ?int $userId = null;

    private ?int $amountDue = null;

    public static function create(?int $offset = null, string $country = null, string $city = null, string $start = null, string $end = null): DelegationSearchCriteria
    {
        $criteria = new self(
            CriteriaPagination::create(self::PAGINATION_SIZE, $offset)
        );

        if (!empty($country)) {
            $criteria->country = $country;
        }

        if (!empty($city)) {
            $criteria->city = $city;
        }

        if (!empty($start)) {
            $criteria->start = $start;
        }

        if (!empty($end)) {
            $criteria->end = $end;
        }

        return $criteria;
    }

    public function country(): ?string
    {
        return $this->country;
    }

    public function city(): ?string
    {
        return $this->city;
    }


    public function userId()
    {
        return $this->userId;
    }
}
