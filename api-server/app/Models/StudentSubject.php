<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentSubject
 * 
 * @property int|null $student_id
 * @property int|null $subject_id
 * @property int $student_subject_id
 * 
 * @property Student|null $student
 * @property Subject|null $subject
 *
 * @package App\Models
 */
class StudentSubject extends Model
{
	protected $table = 'student_subject';
	protected $primaryKey = 'student_subject_id';
	public $timestamps = false;

	protected $casts = [
		'student_id' => 'int',
		'subject_id' => 'int'
	];

	protected $fillable = [
		'student_id',
		'subject_id'
	];

	public function student()
	{
		return $this->belongsTo(Student::class);
	}

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}
}
