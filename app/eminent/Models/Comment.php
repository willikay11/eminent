<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/14/17
 * Time: 9:22 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Comment extends Model
{
    use PresentableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comments';

//    protected $presenter = 'eminent\Roles\RolesPresenter';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_id',
        'comment',
        'user_id'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    /*
     * Relationship between a role and user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(ActivityFile::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}