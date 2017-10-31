<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/23/17
 * Time: 9:53 AM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Contact extends Model
{
    use PresentableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contacts';

    protected $presenter = 'eminent\Contacts\ContactPresenter';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'country_id',
        'address',
        'organization',
        'city',
        'gender_id',
        'religion_id',
        'type',
        'profession_id'
    ];

    /*
     * Set the hidden fields
     */
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');


    /*
     * Relationship between a user and a contacts
     */
    public function user()
    {
        return $this->hasOne(User::class, 'contact_id');
    }

    /*
     * Relationship between a title and a contact
     */
    public function titleName()
    {
        return $this->belongsTo(Title::class, 'title_id');
    }

    /*
     * Religion
     */
    public function religionName()
    {
        return $this->belongsTo(Religions::class);
    }

    /*
     * Country
     */
    public function countryName()
    {
        return $this->belongsTo(Country::class);
    }

    /*
     * Relationship between contact and gender
     */
    public function genderName()
    {
        return $this->belongsTo(Gender::class);
    }

    /*
     * Relationship between a contact and a client
     */
    public function clients()
    {
        return $this->hasOne(Client::class);
    }

    /*
     * Relationship between a contact and a client
     */
    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}