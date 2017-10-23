<?php

namespace eminent\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id',
        'email',
        'designation_id',
        'role_id',
        'password',
        'last_login',
        'employment_date',
        'one_time_key',
        'one_time_key_created_at',
        'active',
        'activation_key',
        'activation_key_created_at',
        'last_sessid',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
