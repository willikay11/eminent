<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 6:27 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'note',
        'user_id'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    /*
     * Relationship between a user and an note
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Relationship between a client and a note
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}