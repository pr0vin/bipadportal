<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationType extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function application_type(){
        return $this->belongsTo(ApplicationType::class);
    }

    public function diseases(){
        return $this->belongsToMany(Disease::class,'disease_applications','application_type_id');
    }
}
