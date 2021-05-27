<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $notification_id
 * @property int $notification_type_id
 * @property string $content
 * @property int $sender
 * @property int $receiver
 * @property Carbon $time_sended
 * @property bool|null $is_readed
 * 
 * @property NotificationType $notification_type
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notification';
	protected $primaryKey = 'notification_id';
	public $timestamps = false;

	protected $casts = [
		'notification_type_id' => 'int',
		'sender' => 'int',
		'receiver' => 'int',
		'is_readed' => 'bool'
	];

	protected $dates = [
		'time_sended'
	];

	protected $fillable = [
		'notification_type_id',
		'content',
		'sender',
		'receiver',
		'time_sended',
		'is_readed'
	];

	public function notification_type()
	{
		return $this->belongsTo(NotificationType::class);
	}
}
