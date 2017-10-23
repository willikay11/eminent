<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:53 AM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'country_id',
        'address',
        'organization',
        'city',
        'gender_id',
        'religion_id',
        'type',
        'profession_id'
    ];

    /*
     * Set the hidden fields
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');
}