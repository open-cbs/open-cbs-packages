<?php

namespace OpenCbs\CbsCif\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenCbs\CbsCif\Actions\CreateCustomerAction;
use OpenCbs\CbsCif\DTOs\CreatePersonDTO;

class CustomerController extends Controller
{
    public function store(Request $request, CreateCustomerAction $action): JsonResponse
    {
        // TODO: Move validation to StoreCustomerRequest
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|in:M,F,O',
            'branch_id' => 'required|integer',
            // ... strict validation rules ...
        ]);

        // Hydrate DTO
        $dto = CreatePersonDTO::fromArray($request->all());

        // Execute Action
        $customer = $action($dto, $request->get('branch_id'));

        return response()->json([
            'message' => 'Customer created successfully',
            'data' => $customer->load(['person.identifications', 'person.addresses'])
        ], 201);
    }
}
