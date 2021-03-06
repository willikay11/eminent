<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 6:01 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'genders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'abbrev'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');
}