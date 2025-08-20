<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\SendMailCommand;
use App\Console\Commands\SendFuneralReminders;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::command(SendMailCommand::class)->everyMinute();

Schedule::command(SendFuneralReminders::class)->everyMinute();
  