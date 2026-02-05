<?php

namespace OpenCbs\CbsCif\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenCbs\CbsCif\Actions\CreateCustomerAction;
use OpenCbs\CbsCif\Actions\UpdateCustomerAction;
use OpenCbs\CbsCif\Actions\DeleteCustomerAction;
use OpenCbs\CbsCif\Actions\GetCustomerAction;
use OpenCbs\CbsCif\DTOs\CreatePersonDTO;
use OpenCbs\CbsCif\DTOs\UpdateCustomerDTO;
use OpenCbs\CbsCif\DTOs\UpdatePersonDTO;
use OpenCbs\CbsCif\Models\Customer;
use OpenCbs\CbsCif\Models\Person;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('can create a customer with identifications and addresses', function () {
    $data = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'dob' => '1990-01-01',
        'gender' => 'M',
        'identifications' => [
            ['type' => 'NID', 'number' => '1234567890'],
        ],
        'addresses' => [
            [
                'type' => 'present',
                'line_1' => '123 Test St',
                'city' => 'Test City',
                'country' => 'Test Country'
            ]
        ]
    ];

    $dto = CreatePersonDTO::fromArray($data);
    $action = new CreateCustomerAction();
    $customer = $action($dto, 'BRANCH-001');

    expect($customer)->toBeInstanceOf(Customer::class)
        ->and($customer->person->first_name)->toBe('John')
        ->and($customer->person->identifications)->toHaveCount(1)
        ->and($customer->person->addresses)->toHaveCount(1);
    
    expect($customer->cif_id)->toStartWith('CIF-');
});

test('can update a customer and person', function () {
    $person = Person::create([
        'first_name' => 'Old',
        'last_name' => 'Name',
        'dob' => '1980-01-01',
        'gender' => 'M'
    ]);

    $customer = Customer::create([
        'cif_id' => 'CIF-PRE',
        'person_id' => $person->id,
        'branch_id' => 'B001',
        'status' => 'active'
    ]);

    $updatePersonDto = UpdatePersonDTO::fromArray(['first_name' => 'New']);
    $updateCustomerDto = UpdateCustomerDTO::fromArray(['status' => 'dormant']);

    $action = new UpdateCustomerAction();
    $updatedCustomer = $action($customer, $updateCustomerDto, $updatePersonDto);

    expect($updatedCustomer->status)->toBe('dormant')
        ->and($updatedCustomer->person->first_name)->toBe('New');
});

test('can soft delete a customer', function () {
    $person = Person::create([
        'first_name' => 'Delete',
        'last_name' => 'Me',
        'dob' => '1980-01-01',
        'gender' => 'M'
    ]);

    $customer = Customer::create([
        'cif_id' => 'CIF-DEL',
        'person_id' => $person->id,
        'branch_id' => 'B001'
    ]);

    $action = new DeleteCustomerAction();
    $result = $action($customer);

    expect($result)->toBeTrue();
    expect(Customer::find($customer->id))->toBeNull();
    expect(Customer::withTrashed()->find($customer->id))->not->toBeNull();
});

test('can retrieve a customer by CIF ID', function () {
    $person = Person::create([
        'first_name' => 'Search',
        'last_name' => 'Target',
        'dob' => '1980-01-01',
        'gender' => 'M'
    ]);

    $customer = Customer::create([
        'cif_id' => 'CIF-SEARCH-01',
        'person_id' => $person->id,
        'branch_id' => 'B001'
    ]);

    $action = new GetCustomerAction();
    $found = $action('CIF-SEARCH-01');

    expect($found->id)->toBe($customer->id);
});
