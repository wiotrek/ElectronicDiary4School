<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentMark
 * 
 * @property int $student_marks_id
 * @property int|null $student_id
 * @property int|null $marks_id
 * @property int|null $subject_id
 * @property int|null $marks_type_id
 * @property int|null $approach_number
 * @property string $topic
 * @property Carbon $passing_date
 * 
 * @property Mark|null $mark
 * @property MarksType|null $marks_type
 * @property Student|null $student
 * @property Subject|null $subject
 *
 * @package App\Models
 */
class StudentMark extends Model
{
	protected $table = 'student_marks';
	protected $primaryKey = 'student_marks_id';
	public $timestamps = false;

	protected $casts = [
		'student_id' => 'int',
		'marks_id' => 'int',
		'subject_id' => 'int',
		'marks_type_id' => 'int',
		'approach_number' => 'int'
	];

	protected $dates = [
		'passing_date'
	];

	protected $fillable = [
		'student_id',
		'marks_id',
		'subject_id',
		'marks_type_id',
		'approach_number',
		'topic',
		'passing_date'
	];

	public function mark()
	{
		return $this->belongsTo(Mark::class, 'marks_id');
	}

	public function marks_type()
	{
		return $this->belongsTo(MarksType::class);
	}

	public function student()
	{
		return $this->belongsTo(Student::class);
	}

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}
}
