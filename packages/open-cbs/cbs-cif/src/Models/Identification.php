<?php

namespace OpenCbs\CbsCif\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenCbs\CbsAddresses\Models\Address;

class Identification extends Model
{
    use SoftDeletes;
    
    protected $table = 'cbs_cif.identifications';
    protected $guarded = [];

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
