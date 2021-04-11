<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $class_harmonogram_id
 * @property int        $class_id
 * @property int        $subject_id
 * @property Date       $date_meeting
 * @property DateTime   $start_time
 * @property DateTime   $end_time
 */
class ClassHarmonogram extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'class_harmonogram';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'class_harmonogram_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_harmonogram_id',
        'class_id',
        'subject_id',
        'date_meeting',
        'start_time',
        'end_time'
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
        'class_harmonogram_id' => 'int',
        'class_id' => 'int',
        'subject_id' => 'int',
        'date_meeting' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_meeting',
        'start_time',
        'end_time'
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
