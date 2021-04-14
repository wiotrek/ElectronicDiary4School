<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubjectClass
 * 
 * @property int $subject_class_id
 * @property int|null $class_id
 * @property int|null $subject_id
 * 
 * @property Subject|null $subject
 * @property UserClass|null $user_class
 *
 * @package App\Models
 */
class SubjectClass extends Model
{
	protected $table = 'subject_class';
	protected $primaryKey = 'subject_class_id';
	public $timestamps = false;

	protected $casts = [
		'class_id' => 'int',
		'subject_id' => 'int'
	];

	protected $fillable = [
		'class_id',
		'subject_id'
	];

	public function subject()
	{
		return $this->belongsTo(Subject::class);
	}

	public function user_class()
	{
		return $this->belongsTo(UserClass::class, 'class_id');
	}
}
