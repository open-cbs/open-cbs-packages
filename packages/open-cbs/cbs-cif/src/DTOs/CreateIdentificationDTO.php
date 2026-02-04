<?php

namespace OpenCbs\CbsCif\DTOs;

use OpenCbs\CbsCore\DTOs\DataTransferObject;

class CreateIdentificationDTO extends DataTransferObject
{
    public string $type;
    public string $number;
    public ?string $issue_date = null;
    public ?string $expiry_date = null;
    public ?string $issuing_authority = null;
}
