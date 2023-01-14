<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentClassIdEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    public $studentId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $studentId)
    {
        $this -> studentId = $studentId;
    }

}
