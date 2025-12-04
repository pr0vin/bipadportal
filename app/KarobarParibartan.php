<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KarobarParibartan extends Model
{
    protected $guarded = [];
    
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
