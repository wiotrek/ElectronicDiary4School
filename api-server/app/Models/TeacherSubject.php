<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TeacherSubject
 * 
 * @property int|null $teacher_id
 * @property int|null $subject_id
 * @property int $teacher_subject_id
 * 
 * @property Subject|null $subject
 * @property Teacher|null $teacher
 *
 * @package App\Models
 */
class TeacherSubject extends Model
{
	protected $table = 'teacher_subject';
	protected $primaryKey = 'teacher_subject_id';
	public $timestamps = false;

	protected $casts = [
		'teacher_id' => 'int',
		'subject_id' => 'int'
	];

	protected $fillable = [
		'teacher_id',
		'subject_id'
	];

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}

	public function teacher()
	{
		return $this->belongsTo(Teacher::class);
	}
}
