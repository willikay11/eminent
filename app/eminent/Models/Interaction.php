<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/31/17
 * Time: 9:44 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'interaction_type_id',
        'interaction_date',
        'remarks'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');
}