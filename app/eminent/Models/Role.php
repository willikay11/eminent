<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:27 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    /*
     * Relationship between a role and user
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /*
     * Relationship between rolepermissions and role
     */
    public function permissions()
    {
        return $this->hasMany('CRM\Models\RolePermission', 'role_id');
    }
}