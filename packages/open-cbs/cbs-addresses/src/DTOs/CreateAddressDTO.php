<?php

namespace OpenCbs\CbsAddresses\DTOs;

use OpenCbs\CbsCore\DTOs\DataTransferObject;

class CreateAddressDTO extends DataTransferObject
{
    public ?string $addressable_id = null;
    public ?string $addressable_type = null;
    public string $type; // present, permanent
    public ?int $division_id = null;
    public ?int $district_id = null;
    public ?int $upazila_id = null;
    public ?int $union_id = null;
    public ?int $village_id = null;
    public ?string $post_code = null;
    public ?string $address_line_1 = null;
    public ?string $address_line_2 = null;
}
