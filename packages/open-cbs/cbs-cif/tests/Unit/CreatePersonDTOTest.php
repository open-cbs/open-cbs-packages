<?php

namespace OpenCbs\CbsCif\Tests\Unit;

use OpenCbs\CbsCif\DTOs\CreatePersonDTO;
use PHPUnit\Framework\TestCase;

class CreatePersonDTOTest extends TestCase
{
    public function test_can_populate_relationships_from_array()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1990-01-01',
            'gender' => 'M',
            'relationships' => [
                ['related_person_id' => 1, 'relationship_type' => 'father'],
                ['related_person_id' => 2, 'relationship_type' => 'mother'],
            ],
        ];

        $dto = CreatePersonDTO::fromArray($data);

        $this->assertIsArray($dto->relationships);
        $this->assertCount(2, $dto->relationships);
        $this->assertEquals(1, $dto->relationships[0]['related_person_id']);
        $this->assertEquals('father', $dto->relationships[0]['relationship_type']);
    }
}
