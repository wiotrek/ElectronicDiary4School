<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ClassHarmonogram
 * 
 * @property int $class_harmonogram_id
 * @property int|null $class_id
 * @property int|null $subject_id
 * @property Carbon $date_meeting
 * @property Carbon $start_time
 * @property Carbon $end_time
 * 
 * @property UserClass|null $user_class
 * @property Subject|null $subject
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
		'subject_id' => 'int'
	];

	protected $dates = [
		'date_meeting',
		'start_time',
		'end_time'
	];

	protected $fillable = [
		'class_id',
		'subject_id',
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
}
