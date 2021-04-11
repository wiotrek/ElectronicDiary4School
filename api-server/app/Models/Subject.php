<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $subject_id
 * @property string     $name
 * @property string     $type
 */
class Subject extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subject';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'subject_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject_id',
        'name',
        'type'
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
        'subject_id' => 'int',
        'name' => 'string',
        'type' => 'string'
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
