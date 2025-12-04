<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'old_registration' => 'boolean'
    ];

    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function address(){
        return $this->belongsTo(Address::class,'address_id','id');
    }
}
