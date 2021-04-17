<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Subject
 * 
 * @property int $subject_id
 * @property string $name
 * @property string|null $icon
 * @property string|null $type
 * 
 * @property Collection|ClassHarmonogram[] $class_harmonograms
 * @property Collection|StudentActivity[] $student_activities
 * @property Collection|StudentMark[] $student_marks
 * @property Collection|SubjectClass[] $subject_classes
 * @property Collection|Teacher[] $teachers
 *
 * @package App\Models
 */
class Subject extends Model
{
	protected $table = 'subject';
	protected $primaryKey = 'subject_id';
	public $timestamps = false;

	protected $fillable = [
		'name',
		'icon',
		'type'
	];

	public function class_harmonograms()
	{
		return $this->hasMany(ClassHarmonogram::class);
	}

	public function student_activities()
	{
		return $this->hasMany(StudentActivity::class);
	}

	public function student_marks()
	{
		return $this->hasMany(StudentMark::class);
	}

	public function subject_classes()
	{
		return $this->hasMany(SubjectClass::class);
	}

	public function teachers()
	{
		return $this->belongsToMany(Teacher::class, 'teacher_subject')
					->withPivot('teacher_subject_id');
	}
}
