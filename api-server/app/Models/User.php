<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $identifier
 * @property boolean $hash_pass
 * @property boolean $salt_pass
 * 
 * @property Collection|Student[] $students
 * @property Collection|Teacher[] $teachers
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'user';
	protected $primaryKey = 'user_id';
	public $timestamps = false;

	protected $casts = [
		'hash_pass' => 'boolean',
		'salt_pass' => 'boolean'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'identifier',
		'hash_pass',
		'salt_pass'
	];

	public function students()
	{
		return $this->hasMany(Student::class);
	}

	public function teachers()
	{
		return $this->hasMany(Teacher::class);
	}
}
