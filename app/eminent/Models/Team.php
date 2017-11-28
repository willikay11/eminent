<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 11/28/17
 * Time: 11:42 AM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Team extends Model
{
    use PresentableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teams';

    protected $presenter = 'eminent\Team\TeamPresenter';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'active'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');

    public function teamHead()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}