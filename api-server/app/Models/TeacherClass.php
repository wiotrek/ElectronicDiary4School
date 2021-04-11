<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $teacher_id
 * @property int        $class_id
 * @property int        $teacher_class_id
 */
class TeacherClass extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teacher_class';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'teacher_class_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'class_id',
        'teacher_class_id'
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
        'teacher_id' => 'int',
        'class_id' => 'int',
        'teacher_class_id' => 'int'
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
