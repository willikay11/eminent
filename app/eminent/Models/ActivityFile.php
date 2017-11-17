<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/17/17
 * Time: 2:55 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class ActivityFile extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id',
        'name',
        'extension',
        'path'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');


    public function activity()
    {
        return $this->belongsTo(Comment::class);
    }
}