<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Student
 * 
 * @property int $student_id
 * @property int|null $user_id
 * @property int|null $class_id
 * @property int|null $role_id
 * 
 * @property UserClass|null $user_class
 * @property Role|null $role
 * @property User|null $user
 * @property Collection|StudentActivity[] $student_activities
 * @property Collection|Mark[] $marks
 * @property Collection|Subject[] $subjects
 *
 * @package App\Models
 */
class Student extends Model
{
	protected $table = 'student';
	protected $primaryKey = 'student_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'class_id' => 'int',
		'role_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'class_id',
		'role_id'
	];

	public function user_class()
	{
		return $this->belongsTo(UserClass::class, 'class_id');
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function student_activities()
	{
		return $this->hasMany(StudentActivity::class);
	}

	public function marks()
	{
		return $this->belongsToMany(Mark::class, 'student_marks', 'student_id', 'marks_id')
					->withPivot('student_marks_id', 'subject_id', 'marks_type_id', 'approach_number', 'topic', 'passing_date');
	}

	public function subjects()
	{
		return $this->belongsToMany(Subject::class)
					->withPivot('student_subject_id');
	}
}
