<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\GenerateStudentActiveList::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('generate:studentActiveList')->
            days([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY, Schedule::FRIDAY])->
            at('08:00');


        $schedule->command('generate:studentActiveList')->
            days([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY, Schedule::FRIDAY])->
            at('08:55');


        $schedule->command('generate:studentActiveList')->
            days([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY, Schedule::FRIDAY])->
            at('09:45');


        $schedule->command('generate:studentActiveList')->
            days([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY, Schedule::FRIDAY])->
            at('10:35');


        $schedule->command('generate:studentActiveList')->
            days([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY, Schedule::FRIDAY])->
            at('11:40');


        $schedule->command('generate:studentActiveList')->
            days([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY, Schedule::FRIDAY])->
            at('12:45');


        $schedule->command('generate:studentActiveList')->
            days([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY, Schedule::THURSDAY, Schedule::FRIDAY])->
            at('13:35');


        $schedule->command('generate:studentActiveList')->
            days([Schedule::MONDAY, Schedule::TUESDAY, Schedule::WEDNESDAY])->
            at('14:25');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
