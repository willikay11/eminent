<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 12/16/17
 * Time: 2:13 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'start_date',
        'end_date',
        'type',
        'description',
        'filters'
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
}