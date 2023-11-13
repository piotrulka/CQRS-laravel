<?php

declare(strict_types=1);

namespace App\Infrastructure\Delegation;

use App\Domain\Delegation\Aggregate\Delegation;
use App\Domain\Delegation\DelegationRepository as DelegationRepositoryInterface;
use App\Domain\Delegation\DelegationSearchCriteria;
use App\Domain\Delegation\Exception\DelegationNotFoundException;
use App\Domain\Delegation\ValueObject\AmountDue;
use App\Domain\Delegation\ValueObject\Country;
use App\Domain\Delegation\ValueObject\Id;
use App\Domain\Delegation\ValueObject\UserId;
use App\Domain\Shared\ValueObject\DateTimeValueObject;
use App\Infrastructure\Laravel\Model\DelegationModel;
use Illuminate\Support\Carbon;

class DelegationRepository implements DelegationRepositoryInterface
{

    public function create(Delegation $delegation): void
    {
        $delegationModel = new DelegationModel();

        $delegationModel->id = $delegation->id()->value();
        $delegationModel->country = $delegation->country()->value();
        $delegationModel->amount_due = $delegation->amountDue()->value();
        $delegationModel->user_id = $delegation->userId()->value();
        $delegationModel->start = Carbon::parse($delegation->start()->value())->toDateTimeString();
        $delegationModel->end = Carbon::parse($delegation->end()->value())->toDateTimeString();
        $delegationModel->created_at = DateTimeValueObject::now()->value();

        $delegationModel->save();
    }

    public function update(Delegation $delegation): void
    {
        // TODO: Implement update() method.
    }

    public function findById(Id $delegationId): Delegation
    {
        $delegationModel = DelegationModel::find($delegationId->value());

        if (empty($delegationModel)) {
            throw new DelegationNotFoundException('Delegation does not exist');
        }

        return self::map($delegationModel);
    }

    public function searchById(Id $delegationId): ?Delegation
    {
        // TODO: Implement searchById() method.
    }

    public function searchByCriteria(DelegationSearchCriteria $criteria): array
    {
        $delegationModel = new DelegationModel();

        if (!empty($criteria->country())) {
            $delegationModel = $delegationModel->where('country', 'LIKE', '%' . $criteria->country() . '%');
        }

        if (!empty($criteria->userId())) {
            $delegationModel = $delegationModel->where('user_id', $criteria->userId());
        }

        if ($criteria->pagination() !== null) {
            $delegationModel = $delegationModel->take($criteria->pagination()->limit()->value())
                ->skip($criteria->pagination()->offset()->value());
        }

        if ($criteria->sort() !== null) {
            $delegationModel = $delegationModel->orderBy($criteria->sort()->field()->value(), $criteria->sort()->direction()->value());
        }

        return array_map(
            static fn (DelegationModel $delegation) => self::map($delegation),
            $delegationModel->get()->all()
        );
    }

    public function delete(Delegation $delegationId): void
    {
        // TODO: Implement delete() method.
    }

    private static function map(DelegationModel $model): Delegation
    {
        return Delegation::create(
            Id::fromPrimitives($model->id),
            Country::fromString($model->country),
            AmountDue::fromInteger($model->amount_due),
            UserId::fromPrimitives($model->user_id),
            DateTimeValueObject::fromPrimitives((string)$model->start),
            DateTimeValueObject::fromPrimitives($model->end),
            DateTimeValueObject::fromPrimitives((string)$model->created_at),
            !empty($model->updated_at) ? DateTimeValueObject::fromPrimitives((string)$model->updated_at) : null,
        );
    }
}
