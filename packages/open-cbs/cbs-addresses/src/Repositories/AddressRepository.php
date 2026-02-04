<?php

namespace OpenCbs\CbsAddresses\Repositories;

use OpenCbs\CbsAddresses\Models\Address;
use OpenCbs\CbsAddresses\DTOs\CreateAddressDTO;
use Illuminate\Database\Eloquent\Collection;

class AddressRepository implements AddressRepositoryInterface
{
    public function create(CreateAddressDTO $data): Address
    {
        return Address::create($data->toArray());
    }

    public function find(int $id): ?Address
    {
        return Address::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $address = $this->find($id);
        if (!$address) {
            return false;
        }
        return $address->update($data);
    }

    public function delete(int $id): bool
    {
        $address = $this->find($id);
        if (!$address) {
            return false;
        }
        return $address->delete();
    }

    public function forAddressable(string $type, int $id): Collection
    {
        return Address::where('addressable_type', $type)
            ->where('addressable_id', $id)
            ->get();
    }
}
