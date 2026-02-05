<?php

namespace OpenCbs\CbsCif\DTOs;

use OpenCbs\CbsCore\DTOs\DataTransferObject;

class UpdateCustomerDTO extends DataTransferObject
{
    public ?string $status = null;
    public ?string $risk_grading = null;
    public ?string $kyc_status = null;
    public ?string $branch_id = null;
}
