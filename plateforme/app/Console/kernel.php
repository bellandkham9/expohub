<?php

function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
{
    $schedule->command('assistant:generate')->everyMinute();
}
