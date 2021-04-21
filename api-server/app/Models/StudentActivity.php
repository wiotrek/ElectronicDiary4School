<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentActivity
 *
 * @property int $student_activity_id
 * @property int|null $student_id
 * @property int|null $subject_id
 * @property int $active
 * @property Carbon $date_active
 *
 * @property Student|null $student
 * @property Subject|null $subject
 *
 * @package App\Models
 */
class StudentActivity extends Model
{
	protected $table = 'student_activity';
	protected $primaryKey = 'student_activity_id';
	public $timestamps = false;

	protected $casts = [
		'student_id' => 'int',
		'subject_id' => 'int',
		'active' => 'int'
	];

	protected $dates = [
		'date_active'
	];

	protected $fillable = [
		'student_id',
		'subject_id',
		'active',
		'date_active'
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
