<?php

namespace OpenCbs\CbsCif\Actions;

use OpenCbs\CbsCore\Actions\Action;
use OpenCbs\CbsCif\Models\Customer;
use OpenCbs\CbsCif\DTOs\UpdateCustomerDTO;
use OpenCbs\CbsCif\DTOs\UpdatePersonDTO;

class UpdateCustomerAction extends Action
{
    public function __invoke(Customer $customer, UpdateCustomerDTO $customerDto, ?UpdatePersonDTO $personDto = null): Customer
    {
        return $this->transaction(function () use ($customer, $customerDto, $personDto) {
            
            // 1. Update Customer fields
            $customer->update(array_filter($customerDto->toArray()));

            // 2. Update Person if provided
            if ($personDto) {
                $person = $customer->person; // Assuming relationship is defined or we can just load it
                if (!$person) {
                    $person = $customer->person()->first();
                }
                
                if ($person) {
                    $person->update(array_filter($personDto->toArray()));
                    
                    // Update Identifications if provided
                    if (!empty($personDto->identifications)) {
                        // For simplicity, we might want to sync or just add new ones. 
                        // Regulatory requirements might require keeping history, but for CRUD let's assume update.
                        // For now, let's just add new ones or handle specifically if needed.
                        foreach ($personDto->identifications as $idDto) {
                            $person->identifications()->updateOrCreate(
                                ['type' => $idDto->type, 'number' => $idDto->number],
                                $idDto->toArray()
                            );
                        }
                    }
                }
            }

            return $customer->fresh(['person', 'person.identifications']);
        });
    }
}
