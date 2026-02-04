<?php

namespace OpenCbs\CbsCif\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use OpenCbs\CbsCif\Models\Person;
use Tests\TestCase;

class PersonRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_and_retrieve_person_relationships()
    {
        // migrate structure inside checking because we are in a package but running from root context usually works if migration paths are registered.
        // assuming standard laravel app structure where package migrations are loaded.

        $father = Person::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1960-01-01',
            'gender' => 'M',
        ]);

        $mother = Person::create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'dob' => '1962-01-01',
            'gender' => 'F',
        ]);

        $son = Person::create([
            'first_name' => 'Jim',
            'last_name' => 'Doe',
            'dob' => '1990-01-01',
            'gender' => 'M',
        ]);

        // Attach relationships
        $son->relationships()->attach($father->id, ['relationship_type' => 'father']);
        $son->relationships()->attach($mother->id, ['relationship_type' => 'mother']);

        // Assert relationships
        $this->assertTrue($son->father->contains($father));
        $this->assertTrue($son->mother->contains($mother));
        $this->assertEquals(1, $son->father->count());
        $this->assertEquals(1, $son->mother->count());
    }
}
