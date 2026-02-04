<?php

namespace OpenCbs\CbsAddresses\Actions;

use Illuminate\Database\Eloquent\Model;
use OpenCbs\CbsCore\Actions\Action;
use OpenCbs\CbsAddresses\DTOs\CreateAddressDTO;
use OpenCbs\CbsAddresses\Models\Address;

class CreateAddressAction extends Action
{
    public function __invoke(Model $owner, CreateAddressDTO $dto): Address
    {
        return $this->transaction(function () use ($owner, $dto) {
            return $owner->addresses()->create($dto->toArray());
        });
    }
}
