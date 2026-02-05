<?php

namespace OpenCbs\CbsCif\DTOs;

use OpenCbs\CbsCore\DTOs\DataTransferObject;

class UpdatePersonDTO extends DataTransferObject
{
    public ?string $title = null;
    public ?string $first_name = null;
    public ?string $middle_name = null;
    public ?string $last_name = null;
    public ?string $dob = null;
    public ?string $gender = null;
    public ?string $blood_group = null;
    public ?string $religion = null;
    public ?string $occupation = null;
    public ?float $monthly_income = null;
    public ?string $mobile_number = null;
    public ?string $email = null;
    public ?string $photo_url = null;
    public ?string $signature_url = null;

    /** @var array<CreateIdentificationDTO> */
    public array $identifications = [];

    /** @var array */
    public array $relationships = [];

    public static function fromArray(array $data): static
    {
        $dto = parent::fromArray($data);

        if (isset($data['identifications']) && is_array($data['identifications'])) {
            $dto->identifications = array_map(fn($item) => CreateIdentificationDTO::fromArray($item), $data['identifications']);
        }

        return $dto;
    }
}
