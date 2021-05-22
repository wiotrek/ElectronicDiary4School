<?php

namespace App\Events;

use App\ApiModels\Subject\SubjectDetailsApiModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class StudentStatisticsEvent It's fire when new frequenty or marks is detect
 * @package App\Events
 */
class StudentStatisticsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var SubjectDetailsApiModel
     */
    public $studentId;

    /**
     * Create a new event instance.
     *
     * @param int $studentId
     */
    public function __construct(int $studentId)
    {
        $this -> studentId = $studentId;
    }

}
