<?php

namespace OpenCbs\CbsAddresses\Http\Controllers;

use App\Http\Controllers\Controller;
use OpenCbs\CbsAddresses\Repositories\AddressRepositoryInterface;
use OpenCbs\CbsAddresses\Http\Requests\StoreAddressRequest;
use OpenCbs\CbsAddresses\DTOs\CreateAddressDTO;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    public function __construct(
        protected AddressRepositoryInterface $repository
    ) {}

    public function store(StoreAddressRequest $request): JsonResponse
    {
        $dto = CreateAddressDTO::fromArray($request->validated());
        $address = $this->repository->create($dto);

        return response()->json([
            'message' => 'Address created successfully',
            'data' => $address
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $address = $this->repository->find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        return response()->json(['data' => $address]);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->repository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        return response()->json(['message' => 'Address deleted successfully']);
    }
}
