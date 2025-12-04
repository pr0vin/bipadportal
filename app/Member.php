<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $guarded=['id'];

    public function committee(){
        return $this->belongsTo(Committee::class);
    }
    public function position(){
        return $this->belongsTo(Position::class);
    }
    public function committeePosition(){
        return $this->belongsTo(CommitteePosition::class);
    }
}
