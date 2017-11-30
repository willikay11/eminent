<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/30/17
 * Time: 2:05 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class ProgressUpdate extends Model
{
    protected $table = 'progress_updates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'activity_id',
        'percentage',
        'progress_update_status_id'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function progressUpdateStatus()
    {
        return $this->belongsTo(ProgressUpdateStatus::class);
    }

    public function progressUpdateFiles()
    {
        return $this->hasMany(ProgressUpdateFile::class);
    }
}