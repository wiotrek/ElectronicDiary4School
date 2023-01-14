<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Mark
 * 
 * @property int $marks_id
 * @property string $degree
 * 
 * @property Collection|Student[] $students
 *
 * @package App\Models
 */
class Mark extends Model
{
	protected $table = 'marks';
	protected $primaryKey = 'marks_id';
	public $timestamps = false;

	protected $fillable = [
		'degree'
	];

	public function students()
	{
		return $this->belongsToMany(Student::class, 'student_marks', 'marks_id')
					->withPivot('student_marks_id', 'subject_id', 'marks_type_id', 'approach_number', 'topic', 'passing_date');
	}
}
