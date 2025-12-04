<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $guarded = [];


    public function districts()
    {
        return $this->hasMany('App\District');
    }

    public function organizations()
    {
        return $this->hasMany('App\Organization', 'org_province_id');
    }
}
