<?php

namespace OpenCbs\CbsCif\Actions;

use OpenCbs\CbsCore\Actions\Action;
use OpenCbs\CbsCif\Models\Customer;

class DeleteCustomerAction extends Action
{
    public function __invoke(Customer $customer, bool $deletePerson = false): bool
    {
        return $this->transaction(function () use ($customer, $deletePerson) {
            
            // Soft delete the customer
            $deleted = $customer->delete();

            if ($deleted && $deletePerson) {
                $person = $customer->person;
                if ($person) {
                    $person->delete();
                }
            }

            return $deleted;
        });
    }
}
