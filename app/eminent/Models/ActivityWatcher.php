<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/22/17
 * Time: 2:28 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class ActivityWatcher extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_watchers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_id',
        'user_id'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    /*
     * Relationship between an activity watcher and user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}