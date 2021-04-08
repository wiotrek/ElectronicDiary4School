<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserClass
 * 
 * @property int $class_id
 * @property int $number
 * @property string $identifier_number
 * 
 * @property Collection|ClassHarmonogram[] $class_harmonograms
 * @property Collection|Student[] $students
 * @property Collection|TeacherClass[] $teacher_classes
 *
 * @package App\Models
 */
class UserClass extends Model
{
	protected $table = 'user_class';
	protected $primaryKey = 'class_id';
	public $timestamps = false;

	protected $casts = [
		'number' => 'int'
	];

	protected $fillable = [
		'number',
		'identifier_number'
	];

	public function class_harmonograms()
	{
		return $this->hasMany(ClassHarmonogram::class, 'class_id');
	}

	public function students()
	{
		return $this->hasMany(Student::class, 'class_id');
	}

	public function teacher_classes()
	{
		return $this->hasMany(TeacherClass::class, 'class_id');
	}
}
