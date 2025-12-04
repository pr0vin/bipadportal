<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    protected $guarded = [];

    protected $dates = ['start_date_ad'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
