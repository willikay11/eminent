<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/31/17
 * Time: 9:34 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class InteractionType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interaction_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');
}