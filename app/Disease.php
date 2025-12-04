<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function application_types(){
        return $this->belongsToMany(ApplicationType::class,'disease_applications','disease_id');
    }

}
