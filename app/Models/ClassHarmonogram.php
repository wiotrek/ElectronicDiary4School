<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ClassHarmonogram
 * 
 * @property int $class_harmonogram_id
 * @property int|null $class_id
 * @property int|null $subject_id
 * @property int|null $teacher_id
 * @property string $date_meeting
 * @property string $start_time
 * @property string $end_time
 * 
 * @property UserClass|null $user_class
 * @property Subject|null $subject
 * @property Teacher|null $teacher
 *
 * @package App\Models
 */
class ClassHarmonogram extends Model
{
	protected $table = 'class_harmonogram';
	protected $primaryKey = 'class_harmonogram_id';
	public $timestamps = false;

	protected $casts = [
		'class_id' => 'int',
		'subject_id' => 'int',
		'teacher_id' => 'int'
	];

	protected $fillable = [
		'class_id',
		'subject_id',
		'teacher_id',
		'date_meeting',
		'start_time',
		'end_time'
	];

	public function user_class()
	{
		return $this->belongsTo(UserClass::class, 'class_id');
	}

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}

	public function teacher()
	{
		return $this->belongsTo(Teacher::class);
	}
}
