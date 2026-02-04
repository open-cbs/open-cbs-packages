<?php

namespace OpenCbs\CbsAddresses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Upazila extends Model
{
    use SoftDeletes, HasRelationships;

    protected $table = 'cbs_addresses.upazilas';
    protected $guarded = [];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function unions()
    {
        return $this->hasMany(Union::class);
    }

    public function villages()
    {
        return $this->hasManyThrough(Village::class, Union::class);
    }
}
