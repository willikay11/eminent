<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/4/17
 * Time: 3:12 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_types';

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


    public function activityTypes()
    {
        return $this->hasMany(Activity::class);
    }
}