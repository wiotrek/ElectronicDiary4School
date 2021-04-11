<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $student_activity_id
 * @property int        $student_id
 * @property int        $subject_id
 * @property boolean    $active
 * @property Date       $date_active
 */
class StudentActivity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_activity';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'student_activity_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_activity_id',
        'student_id',
        'subject_id',
        'active',
        'date_active'
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
        'student_activity_id' => 'int',
        'student_id' => 'int',
        'subject_id' => 'int',
        'active' => 'boolean',
        'date_active' => 'date'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'date_active'
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
