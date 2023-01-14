<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TeacherClass
 * 
 * @property int|null $teacher_id
 * @property int|null $class_id
 * @property int $teacher_class_id
 * 
 * @property UserClass|null $user_class
 * @property Teacher|null $teacher
 *
 * @package App\Models
 */
class TeacherClass extends Model
{
	protected $table = 'teacher_class';
	protected $primaryKey = 'teacher_class_id';
	public $timestamps = false;

	protected $casts = [
		'teacher_id' => 'int',
		'class_id' => 'int'
	];

	protected $fillable = [
		'teacher_id',
		'class_id'
	];

	public function user_class()
	{
		return $this->belongsTo(UserClass::class, 'class_id');
	}

	public function teacher()
	{
		return $this->belongsTo(Teacher::class);
	}
}
