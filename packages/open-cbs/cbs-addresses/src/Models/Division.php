<?php

namespace OpenCbs\CbsAddresses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Division extends Model
{
    use SoftDeletes, HasRelationships;

    protected $table = 'cbs_addresses.divisions';
    protected $guarded = [];

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function upazilas()
    {
        return $this->hasManyThrough(Upazila::class, District::class);
    }

    public function unions()
    {
        return $this->hasManyDeep(Union::class, [District::class, Upazila::class]);
    }

    public function villages()
    {
        return $this->hasManyDeep(Village::class, [District::class, Upazila::class, Union::class]);
    }
}
