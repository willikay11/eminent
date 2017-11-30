<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/9/17
 * Time: 10:22 AM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Activity extends Model
{
    use PresentableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';

//    protected $presenter = 'eminent\Clients\ClientsPresenter';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'priority_type_id',
        'activity_status_id',
        'due_date',
        'created_by'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');


    public function activityStatus()
    {
        return $this->belongsTo(ActivityStatus::class);
    }

    public function priorityType()
    {
        return $this->belongsTo(PriorityType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assigner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function activityWatchers()
    {
        return $this->hasMany(ActivityWatcher::class);
    }

    public function progressUpdates()
    {
        return $this->hasMany(ProgressUpdate::class);
    }
}