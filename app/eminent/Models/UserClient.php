<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 3:30 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class UserClient extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'user_id',
        'next_interaction_date'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    /*
     * Relationship between a user and a userclient
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Relationship Between a client and a userclient
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}