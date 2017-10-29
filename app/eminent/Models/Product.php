<?php
/**
 * Created by PhpStorm.
 * User: mac-intern
 * Date: 10/29/17
 * Time: 2:33 PM
 */

namespace eminent\Models;


use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Product extends Model
{
    use PresentableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'abbrev',
        'active'
    ];

    /**
     * Fields that should not be mass assigned
     * @var array
     */
    protected $guarded = array('id', 'created_at', 'updated_at');
}