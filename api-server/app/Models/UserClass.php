<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $class_id
 * @property int        $number
 * @property string     $identifier_number
 */
class UserClass extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_class';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'class_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_id',
        'number',
        'identifier_number'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'class_id' => 'int',
        'number' => 'int',
        'identifier_number' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [

    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Scopes...

    // Functions ...

    // Relations ...
}
