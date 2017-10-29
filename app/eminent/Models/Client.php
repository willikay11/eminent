<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 3:25 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Client extends Model
{
    use PresentableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

    protected $presenter = 'eminent\Clients\ClientsPresenter';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contact_id',
        'source_id',
        'status_id'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');


    /*
     * Relationship between a contact and a client
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /*
     * Relationship between a client and a source
     */
    public function source()
    {
        return $this->belongsTo(Sources::class);
    }

    /*
     * Relationship between a client and a clientstatus
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /*
     * Relationship between a client and a user
     */
    public function userClient()
    {
        return $this->hasMany(UserClient::class);
    }
}