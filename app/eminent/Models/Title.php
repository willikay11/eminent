<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/26/17
 * Time: 12:37 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'titles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');
}