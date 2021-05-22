<?php

namespace App\Listeners;


/**
 * Class UpdateStudentAvgMarks The Listen for new mark
 * Then update or create average marks statistics
 * @package App\Listeners
 */
class UpdateStudentAvgMarks
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle( object $event)
    {
        echo ('student id from avg marks: '.$event->studentId)."\n";
    }
}
