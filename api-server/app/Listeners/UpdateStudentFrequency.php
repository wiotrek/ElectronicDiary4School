<?php

namespace App\Listeners;


/**
 * Class UpdateStudentFrequency The listen for store new student frequenty
 * Then update or create frequenty statistics
 * @package App\Listeners
 */
class UpdateStudentFrequency
{
    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle( object $event)
    {
        echo ('student id from frequency: '.$event->studentId)."\n";
    }
}
