<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/9/17
 * Time: 10:24 AM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class ActivityStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_statuses';

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