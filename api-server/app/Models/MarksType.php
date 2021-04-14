<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MarksType
 * 
 * @property int $marks_type_id
 * @property string $mark_from
 * @property float $weights
 * 
 * @property Collection|StudentMark[] $student_marks
 *
 * @package App\Models
 */
class MarksType extends Model
{
	protected $table = 'marks_type';
	protected $primaryKey = 'marks_type_id';
	public $timestamps = false;

	protected $casts = [
		'weights' => 'float'
	];

	protected $fillable = [
		'mark_from',
		'weights'
	];

	public function student_marks()
	{
		return $this->hasMany(StudentMark::class);
	}
}
