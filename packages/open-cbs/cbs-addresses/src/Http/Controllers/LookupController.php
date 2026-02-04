<?php

namespace OpenCbs\CbsAddresses\Http\Controllers;

use App\Http\Controllers\Controller;
use OpenCbs\CbsAddresses\Models\Division;
use OpenCbs\CbsAddresses\Models\District;
use OpenCbs\CbsAddresses\Models\Upazila;
use OpenCbs\CbsAddresses\Models\Union;
use Illuminate\Http\JsonResponse;

class LookupController extends Controller
{
    public function divisions(): JsonResponse
    {
        return response()->json(['data' => Division::all()]);
    }

    public function districts(int $divisionId): JsonResponse
    {
        return response()->json([
            'data' => District::where('division_id', $divisionId)->get()
        ]);
    }

    public function upazilas(int $districtId): JsonResponse
    {
        return response()->json([
            'data' => Upazila::where('district_id', $districtId)->get()
        ]);
    }

    public function unions(int $upazilaId): JsonResponse
    {
        return response()->json([
            'data' => Union::where('upazila_id', $upazilaId)->get()
        ]);
    }
}
