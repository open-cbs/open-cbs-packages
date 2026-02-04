<?php

namespace OpenCbs\CbsAddresses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Union extends Model
{
    use SoftDeletes, HasRelationships;

    protected $table = 'cbs_addresses.unions';
    protected $guarded = [];

    public function upazila()
    {
        return $this->belongsTo(Upazila::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
