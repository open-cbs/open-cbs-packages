<?php

namespace OpenCbs\CbsCif\Actions;

use OpenCbs\CbsCore\Actions\Action;
use OpenCbs\CbsCif\Models\Customer;

class GetCustomerAction extends Action
{
    public function __invoke(string|int $id, bool $includeRelations = true): Customer
    {
        $query = Customer::query();

        if ($includeRelations) {
            $query->with([
                'person',
                'person.identifications',
                'person.addresses',
                'addresses'
            ]);
        }

        if (is_numeric($id)) {
            return $query->findOrFail($id);
        }

        return $query->where('cif_id', $id)->firstOrFail();
    }
}
