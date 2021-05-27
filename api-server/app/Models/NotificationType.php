<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NotificationType
 * 
 * @property int $notification_type_id
 * @property string|null $type
 * 
 * @property Collection|Notification[] $notifications
 *
 * @package App\Models
 */
class NotificationType extends Model
{
	protected $table = 'notification_type';
	protected $primaryKey = 'notification_type_id';
	public $timestamps = false;

	protected $fillable = [
		'type'
	];

	public function notifications()
	{
		return $this->hasMany(Notification::class);
	}
}
