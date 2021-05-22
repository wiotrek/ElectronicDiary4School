<?php

namespace App\Providers;

use App\Events\StudentStatisticsEvent;
use App\Listeners\UpdateStudentFrequency;
use App\Listeners\UpdateStudentAvgMarks;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        StudentStatisticsEvent::class => [
            UpdateStudentAvgMarks::class,
            UpdateStudentFrequency::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
