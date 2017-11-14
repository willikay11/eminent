<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/9/17
 * Time: 10:25 AM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class PriorityType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'priority_types';

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


    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}