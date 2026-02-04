<?php

namespace OpenCbs\CbsAddresses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class District extends Model
{
    use SoftDeletes, HasRelationships;

    protected $table = 'cbs_addresses.districts';
    protected $guarded = [];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function upazilas()
    {
        return $this->hasMany(Upazila::class);
    }

    public function unions()
    {
        return $this->hasManyThrough(Union::class, Upazila::class);
    }

    public function villages()
    {
        return $this->hasManyDeep(Village::class, [Upazila::class, Union::class]);
    }
}
