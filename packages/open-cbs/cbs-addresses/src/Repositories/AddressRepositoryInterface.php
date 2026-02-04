<?php

namespace OpenCbs\CbsAddresses\Repositories;

use OpenCbs\CbsAddresses\Models\Address;
use OpenCbs\CbsAddresses\DTOs\CreateAddressDTO;
use Illuminate\Database\Eloquent\Collection;

interface AddressRepositoryInterface
{
    public function create(CreateAddressDTO $data): Address;
    public function find(int $id): ?Address;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
    public function forAddressable(string $type, int $id): Collection;
}
