<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];

    public function province()
    {
        return $this->belongsTo('App\Province');
    }

    public function municipalities()
    {
        return $this->hasMany('App\Municipality');
    }

    public function organizations()
    {
        return $this->hasMany('App\Organization', 'org_district_id');
    }
}
