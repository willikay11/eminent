<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/20/17
 * Time: 7:44 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class UserHasRole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_has_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    /*
    * Relationship between a role and user_has_role
    */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /*
     * Relationship between a user_has_role and a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}