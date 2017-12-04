<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/31/17
 * Time: 9:44 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'interaction_type_id',
        'interaction_date',
        'remarks',
        'feedback'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    /*
     * Relationship between a user and an interaction
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Relationship between a client and an interaction
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /*
     * Relationship between an interaction and an interactiontype
     */
    public function interactionType()
    {
        return $this->belongsTo(InteractionType::class);
    }
}