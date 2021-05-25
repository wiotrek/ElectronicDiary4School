<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentStatistic
 *
 * @property int $student_statistics_id
 * @property int|null $student_id
 * @property int|null $subject_id
 * @property float|null $average_marks
 * @property int|null $average_position
 * @property float|null $frequency
 * @property int|null $frequency_position
 *
 * @property Student|null $student
 * @property Subject|null $subject
 *
 * @package App\Models
 */
class StudentStatistics extends Model
{
	protected $table = 'student_statistics';
	protected $primaryKey = 'student_statistics_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'student_statistics_id' => 'int',
		'student_id' => 'int',
		'subject_id' => 'int',
		'average_marks' => 'float',
		'average_position' => 'int',
		'frequency' => 'float',
		'frequency_position' => 'int'
	];

	protected $fillable = [
		'student_id',
		'subject_id',
		'average_marks',
		'average_position',
		'frequency',
		'frequency_position'
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
