<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function type(){
        return $this->belongsTo(ApplicationType::class,'application_type_id','id');
    }
}
