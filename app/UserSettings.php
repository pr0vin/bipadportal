<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    protected $guarded = ['id'];

    // relate settings to user
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
