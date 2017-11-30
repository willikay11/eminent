<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/30/17
 * Time: 2:08 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class ProgressUpdateFile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'progress_update_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'progress_update_id',
        'name',
        'extension',
        'path'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');


    public function progressUpdate()
    {
        return $this->belongsTo(ProgressUpdate::class);
    }
}