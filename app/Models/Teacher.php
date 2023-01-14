<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Teacher
 * 
 * @property int $teacher_id
 * @property int|null $user_id
 * @property int|null $role_id
 * 
 * @property Role|null $role
 * @property User|null $user
 * @property Collection|ClassHarmonogram[] $class_harmonograms
 * @property Collection|TeacherClass[] $teacher_classes
 * @property Collection|Subject[] $subjects
 *
 * @package App\Models
 */
class Teacher extends Model
{
	protected $table = 'teacher';
	protected $primaryKey = 'teacher_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'role_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'role_id'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function class_harmonograms()
	{
		return $this->hasMany(ClassHarmonogram::class);
	}

	public function teacher_classes()
	{
		return $this->hasMany(TeacherClass::class);
	}

	public function subjects()
	{
		return $this->belongsToMany(Subject::class, 'teacher_subject')
					->withPivot('teacher_subject_id');
	}
}
