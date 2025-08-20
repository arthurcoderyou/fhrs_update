<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\FuneralSchedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Helpers\FuneralReminderHelper;
use App\Mail\FuneralScheduleReminder; 
use App\Models\FuneralScheduleNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendFuneralRemindersNotification;

class SendFuneralReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-funeral-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for upcoming funeral schedules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->startOfDay();


        $days = \App\Models\Setting::getFuneralScheduleDays(); 

        $dateDaysRangeToNotify = now()->copy()->addDays($days)->startOfDay();

        $schedules = FuneralSchedule::whereBetween('date', [$today, $dateDaysRangeToNotify])->get();

        foreach ($schedules as $schedule) {
            
            
            
            // // You should define recipients — for now, assuming a `User` model with an email list
            // foreach (\App\Models\User::all() as $user) { 

            //     $alreadyNotified = FuneralScheduleNotification::where('user_id', $user->id)
            //         ->where('funeral_schedule_id', $schedule->id)
            //         ->whereDate('notified_at', Carbon::today())
            //         ->exists();

            //     if (! $alreadyNotified) {


            //         // Mail::to($user->email)->queue(new FuneralScheduleReminder($schedule));

            //         Notification::send($user, new SendFuneralRemindersNotification($schedule));


            //         activity('funeral_schedule')
            //             ->performedOn($schedule)
            //             ->causedBy($user)
            //             ->event('email notification') // ✅ Set the event column value
            //             ->withProperties([
            //                 'schedule_id' => $schedule->id,
            //                 'name_of_person' => $schedule->name_of_person,
            //                 'schedule_date' => $schedule->date,
            //                 'notified_user_email' => $user->email,
            //                 'triggered_by' => 'console:send-funeral-reminders',
            //                 'custom_event' => 'email_notification', // <--- Add this
            //             ])
            //             ->log("Funeral reminder sent to {$user->email} for '{$schedule->name_of_person}' on {$schedule->date->format('F j, Y')}.");  


            //         // Record the notification
            //         FuneralScheduleNotification::create([
            //             'user_id' => $user->id,
            //             'funeral_schedule_id' => $schedule->id,
            //             'notified_at' => now(),
            //         ]);

            //     }

            // }



            FuneralReminderHelper::sendReminderToAllUsers($schedule, 'console:send-funeral-reminders');




        }

        $this->info('Funeral reminders sent.');
        



    }
}
