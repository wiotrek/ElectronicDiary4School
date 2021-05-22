<?php

namespace App\Events;

use App\ApiModels\Subject\SubjectDetailsApiModel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExampleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var SubjectDetailsApiModel
     */
    public $subjectDetails;

    /**
     * Create a new event instance.
     *
     * @param SubjectDetailsApiModel $subjectDetails
     */
    public function __construct(SubjectDetailsApiModel $subjectDetails)
    {
        $this -> subjectDetails = $subjectDetails;
    }

}
