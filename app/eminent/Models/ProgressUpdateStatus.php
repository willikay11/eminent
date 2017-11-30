<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/30/17
 * Time: 2:10 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class ProgressUpdateStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'progress_update_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');


    public function progressUpdate()
    {
        return $this->hasMany(ProgressUpdate::class);
    }
}