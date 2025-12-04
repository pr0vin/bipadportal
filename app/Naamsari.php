<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Naamsari extends Model
{
    protected $guarded = [];

    public function organization() 
    {
        return $this->belongsTo(Organization::class);
    }
}
