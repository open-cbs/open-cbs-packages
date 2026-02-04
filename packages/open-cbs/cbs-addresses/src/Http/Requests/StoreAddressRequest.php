<?php

namespace OpenCbs\CbsAddresses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Logic handled in policy if needed, or simple true for now
    }

    public function rules(): array
    {
        return [
            'addressable_id' => 'required',
            'addressable_type' => 'required|string',
            'type' => 'required|string|in:present,permanent,office,residence',
            'division_id' => 'required|exists:cbs_addresses.divisions,id',
            'district_id' => 'required|exists:cbs_addresses.districts,id',
            'upazila_id' => 'nullable|exists:cbs_addresses.upazilas,id',
            'union_id' => 'nullable|exists:cbs_addresses.unions,id',
            'village_id' => 'nullable|exists:cbs_addresses.villages,id',
            'post_code' => 'nullable|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
        ];
    }
}
