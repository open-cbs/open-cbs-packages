<?php

namespace OpenCbs\CbsAddresses\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Village extends Model
{
    use SoftDeletes, HasRelationships;

    protected $table = 'cbs_addresses.villages';
    protected $guarded = [];

    public function union()
    {
        return $this->belongsTo(Union::class);
    }
}
