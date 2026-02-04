<?php

namespace OpenCbs\CbsCif\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenCbs\CbsAddresses\Models\Address;

class Person extends Model
{
    use SoftDeletes;

    protected $table = 'cbs_cif.persons';
    protected $guarded = [];


    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function relationships()
    {
        return $this->belongsToMany(Person::class, 'cbs_cif.person_relationships', 'person_id', 'related_person_id')
            ->withPivot('relationship_type')
            ->withTimestamps();
    }

    public function father()
    {
        return $this->relationships()->wherePivot('relationship_type', 'father');
    }

    public function mother()
    {
        return $this->relationships()->wherePivot('relationship_type', 'mother');
    }

    public function spouse()
    {
        return $this->relationships()->wherePivot('relationship_type', 'spouse');
    }
}
