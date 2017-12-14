<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/14/17
 * Time: 1:02 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_feedbacks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject',
        'message',
        'user_id'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}