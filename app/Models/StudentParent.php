<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentParent
 * 
 * @property int $student_parent_id
 * @property int $user_id
 * @property int $student_id
 * @property int $role_id
 * 
 * @property Student $student
 *
 * @package App\Models
 */
class StudentParent extends Model
{
	protected $table = 'student_parent';
	protected $primaryKey = 'student_parent_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'student_id' => 'int',
		'role_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'student_id',
		'role_id'
	];

	public function student()
	{
		return $this->belongsTo(Student::class);
	}
}
