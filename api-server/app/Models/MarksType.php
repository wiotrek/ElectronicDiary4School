<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $marks_type_id
 * @property string     $mark_from
 * @property float      $weights
 */
class MarksType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'marks_type';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'marks_type_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'marks_type_id',
        'mark_from',
        'weights'
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
        'marks_type_id' => 'int',
        'mark_from' => 'string',
        'weights' => 'float'
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
