<?php

namespace eminent\Models;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laracasts\Presenter\PresentableTrait;

class User extends Authenticatable
{
    use Notifiable;
    use PresentableTrait;

    protected $presenter = 'eminent\Users\UserPresenter';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id',
        'email',
        'designation_id',
        'department_id',
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

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setEmploymentDateAttribute($employmentDate)
    {
        $this->attributes['employment_date'] = Carbon::parse($employmentDate)->toDateString();
    }


    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function userClients()
    {
        return $this->hasMany(UserClient::class);
    }
}
