<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/2/17
 * Time: 8:03 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interest extends Model
{
    /*
     * Get the softdeletes trait
     */
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'interests';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id',
        'client_id',
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /*
     * Relationship between a client and an interest
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}