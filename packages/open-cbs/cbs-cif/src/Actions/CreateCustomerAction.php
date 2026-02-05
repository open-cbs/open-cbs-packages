<?php

namespace OpenCbs\CbsCif\Actions;

use OpenCbs\CbsCore\Actions\Action;
use OpenCbs\CbsCif\DTOs\CreatePersonDTO;
use OpenCbs\CbsCif\Models\Customer;
use OpenCbs\CbsCif\Models\Person;
use OpenCbs\CbsAddresses\Actions\CreateAddressAction;

class CreateCustomerAction extends Action
{
    public function __invoke(CreatePersonDTO $personDto, string $branchId): Customer
    {
        return $this->transaction(function () use ($personDto, $branchId) {

            // 1. Create Person
            $person = Person::create($personDto->toArray());

            // 2. Add Identifications
            foreach ($personDto->identifications as $idDto) {
                $person->identifications()->create($idDto->toArray());
            }

            // 3. Create Customer Record
            $customer = Customer::create([
                'cif_id' => $this->generateCifId(),
                'person_id' => $person->id,
                'branch_id' => $branchId,
                'status' => 'active',
                'kyc_status' => 'pending'
            ]);

            // 4. Handle Addresses
            $createAddressAction = new CreateAddressAction();
            foreach ($personDto->addresses as $addrDto) {
                $createAddressAction($person, $addrDto);
            }

            return $customer;
        });
    }

    private function generateCifId(): string
    {
        // Simple generation logic for now. 
        return 'CIF-' . date('Ymd') . '-' . rand(1000, 9999);
    }
}
