<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $student_marks_id
 * @property int        $student_id
 * @property int        $marks_id
 * @property int        $subject_id
 * @property int        $marks_type_id
 * @property int        $approach_number
 * @property string     $topic
 * @property DateTime   $passing_date
 */
class StudentMarks extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_marks';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'student_marks_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_marks_id',
        'student_id',
        'marks_id',
        'subject_id',
        'marks_type_id',
        'approach_number',
        'topic',
        'passing_date'
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
        'student_marks_id' => 'int',
        'student_id' => 'int',
        'marks_id' => 'int',
        'subject_id' => 'int',
        'marks_type_id' => 'int',
        'approach_number' => 'int',
        'topic' => 'string',
        'passing_date' => 'datetime'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'passing_date'
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
