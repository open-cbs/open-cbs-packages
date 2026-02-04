<?php

namespace OpenCbs\CbsCif\DTOs;

use OpenCbs\CbsCore\DTOs\DataTransferObject;

class CreatePersonDTO extends DataTransferObject
{
    public string $first_name;
    public string $last_name;
    public ?string $middle_name = null;


    // Relationships (father, mother, spouse) are now handled via relationships array

    public string $dob;
    public string $gender; // M, F, O
    public ?string $mobile_number = null;
    public ?string $email = null;

    /** @var array<CreateIdentificationDTO> */
    public array $identifications = [];

    /** @var array<CreateAddressDTO> */
    public array $addresses = [];

    /** @var array */
    public array $relationships = [];

    /**
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        $dto = parent::fromArray($data);

        if (isset($data['identifications']) && is_array($data['identifications'])) {
            $dto->identifications = array_map(fn($item) => CreateIdentificationDTO::fromArray($item), $data['identifications']);
        }

        if (isset($data['relationships']) && is_array($data['relationships'])) {
            $dto->relationships = $data['relationships'];
        }


        // Addresses will be handled by a DTO from the cbs-addresses package if we want strict typing, 
        // or generic array if we want loose coupling. Let's assume generic for this DTO or define a local one.
        // For strictness, let's define it.

        return $dto;
    }
}
