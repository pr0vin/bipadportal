<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasPermissions;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'municipality_id', 'ward_id', 'is_municipality_login'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['settings'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // grab the user settings
    public function settings()
    {
        return $this->hasOne('App\UserSettings')->withDefault();
    }

    /**
     * Get the Municipality the user belongs to
     *
     * @return void
     */
    public function municipality()
    {
        return $this->belongsTo('App\Address')->withDefault([
            'name' => null
        ]);
    }

    /**
     * Get the ward the user belongs to
     *
     * @return void
     */
    public function ward()
    {
        return $this->belongsTo('App\Ward')->withDefault([
            'name' => null
        ]);
    }

    public function profile(){
        return $this->hasOne(DoctorProfile::class);
    }
}
