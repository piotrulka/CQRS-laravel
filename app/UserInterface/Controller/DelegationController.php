<?php

declare(strict_types=1);

namespace App\UserInterface\Controller;

use App\Domain\Delegation\Aggregate\Delegation;
use App\Domain\Delegation\DelegationSearchCriteria;
use App\Domain\Delegation\ValueObject\AmountDue;
use App\Domain\Delegation\ValueObject\Country;
use App\Domain\Delegation\ValueObject\Id;
use App\Domain\Delegation\ValueObject\UserId;
use App\Domain\Shared\ValueObject\DateTimeValueObject;
use App\Domain\User\UserRepository;
use App\Infrastructure\Delegation\DelegationRepository;
use App\Infrastructure\Laravel\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DelegationController extends Controller
{
    public function index(Request $request, DelegationRepository $delegationRepository): JsonResponse
    {
        $userId = $request->query('user_id');

        $criteria = DelegationSearchCriteria::create(
            !empty($userId) && !is_array($userId) ? (int) $userId : null,
        );

        $delegations = $delegationRepository->searchByCriteria($criteria);

        return response()->json([
            'delegations' => array_map(fn (Delegation $delegation) => $delegation->asArray(), $delegations)
        ]);
    }

    public function store(Request $request, DelegationRepository $delegationRepository): JsonResponse
    {
        $providedStart = $request->input('start');
        $providedEnd = $request->input('end');
        $providedCountry = $request->input('country');
        $providedUserId = $request->input('user_id');


        $delegation = Delegation::create(
            Id::random(),
            Country::fromString($providedCountry),
            AmountDue::fromInteger(0),
            UserId::fromPrimitives($providedUserId),
            DateTimeValueObject::fromPrimitives($providedStart),
            DateTimeValueObject::fromPrimitives($providedEnd),
            DateTimeValueObject::now()
        );

        $delegationRepository->create($delegation);

        return response()->json([
            'delegation' => $delegation
        ], \Illuminate\Http\JsonResponse::HTTP_CREATED);
    }

    public function update(Request $request,  DelegationRepository $delegationRepository, string $id): \Illuminate\Http\JsonResponse
    {
        $user = $delegationRepository->findById(Id::fromPrimitives($id));

        return response()->json([
            'user' => $user->asArray()
        ]);
    }

    public function destroy(DelegationRepository $delegationRepository, string $id): \Illuminate\Http\JsonResponse
    {
        $delegation = $delegationRepository->findById(Id::fromPrimitives($id));

        $delegationRepository->delete($delegation);

        return response()->json([], JsonResponse::HTTP_NO_CONTENT);
    }
}
