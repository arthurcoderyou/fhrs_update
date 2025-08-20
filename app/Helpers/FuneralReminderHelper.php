<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Models\FuneralSchedule;
use App\Models\FuneralScheduleNotification;
use App\Notifications\SendFuneralRemindersNotification;

class FuneralReminderHelper
{
    public static function sendReminderToAllUsers(FuneralSchedule $schedule, string $triggeredBy = 'system')
    {
        foreach (User::where('notification_enabled',true)->get() as $user) {

            $alreadyNotified = FuneralScheduleNotification::where('user_id', $user->id)
                ->where('funeral_schedule_id', $schedule->id)
                ->whereDate('notified_at', Carbon::today())
                ->exists();

            if( $user->hasRole('Global Administrator') || $user->can('funeral schedule subscriber') ){ // check if the user must be notified of the email

                if (! $alreadyNotified) {

                    Notification::send($user, new SendFuneralRemindersNotification($schedule));

                     
                    //whatsapp notification 
                    if(!empty($user->phone) && !empty($user->phone_verified_at)){


                        $message = "";
                        $message .= "Funeral Schedule Reminder\n\n";
                        $message .= "Dear " . $user->name . ",\n\n";
                        $message .= "This is a respectful reminder that there is a scheduled funeral for:\n\n";
                        $message .= "Name of the deceased: " . $schedule->name_of_person . "\n";
                        $message .= "Date and Time: " . Carbon::parse($schedule->date)->format('F j, Y') . "\n";
                        $message .= "Location: " . $schedule->burial_cemetery . " at " . $schedule->burial_location . "\n\n";
                        $message .= "This notification is shared with relevant team members for awareness and coordination.\n\n";

                        $message .= "Overall Funeral Details:\n";
                        $message .= "- Name of Person: " . $schedule->name_of_person . "\n";
                        $message .= "- Date: " . Carbon::parse($schedule->date)->format('F j, Y') . "\n";
                        $message .= "- Mass Time: " . Carbon::parse($schedule->mass_time)->format('g:i A') . "\n";
                        $message .= "- Public Viewing: " . Carbon::parse($schedule->public_viewing_start)->format('g:i A') . " - " . Carbon::parse($schedule->public_viewing_end)->format('g:i A') . "\n";
                        $message .= "- Family Viewing: " . Carbon::parse($schedule->family_viewing_start)->format('g:i A') . " - " . Carbon::parse($schedule->family_viewing_end)->format('g:i A') . "\n";
                        $message .= "- Burial Cemetery: " . $schedule->burial_cemetery . "\n";
                        $message .= "- Burial Location: " . $schedule->burial_location . "\n";
                        $message .= "- Hearse: " . $schedule->hearse . "\n";
                        $message .= "- Funeral Director: " . $schedule->funeral_director . "\n";

                        if ($schedule->co_funeral_director) {
                            $message .= "- Co-Funeral Director: " . $schedule->co_funeral_director . "\n";
                        }


                        $familyArrivals = $schedule->familyArrivals->map(function ($arrival) {
                            return [
                                'time' => optional($arrival->time)->format('H:i'),
                                'notes' => $arrival->notes,
                            ];
                        })->toArray();

                        $flowers = $schedule->flowers->map(function ($flower) {
                            return [
                                'name' => $flower->name,
                                'notes' => $flower->notes,
                            ];
                        })->toArray();

                        $equipments = $schedule->equipments->map(function ($equipment) {
                            return [
                                'name' => $equipment->name,
                                'notes' => $equipment->notes,
                            ];
                        })->toArray();


                        if ($user->hasRole('Global Administrator') || $user->can('funeral schedule view family arrival')) {
                            if (!empty($familyArrivals) && count($familyArrivals)) {
                                $message .= "\nFamily Arrival:\n";
                                foreach ($familyArrivals as $arrival) {
                                    $message .= "- " . $arrival['time'] . ": " . $arrival['notes'] . "\n";
                                }
                            }
                        }

                        if ($user->hasRole('Global Administrator') || $user->can('funeral schedule view flowers')) {
                            if (!empty($flowers) && count($flowers)) {
                                $message .= "\nFlowers:\n";
                                foreach ($flowers as $flower) {
                                    $message .= "- " . $flower['name'] . ": " . $flower['notes'] . "\n";
                                }
                            }
                        }

                        if ($user->hasRole('Global Administrator') || $user->can('funeral schedule view equipments')) {
                            if (!empty($equipments) && count($equipments)) {
                                $message .= "\nEquipments:\n";
                                foreach ($equipments as $equipment) {
                                    $message .= "- " . $equipment['name'] . ": " . $equipment['notes'] . "\n";
                                }
                            }
                        }


                        $url = route('funeral_schedule.show',['funeral_schedule' => $schedule->id]);
                        $message .= "\nView Funeral Schedule: \n" . $url . "\n\n";
                        $message .= "Please review the schedule and prepare accordingly.\n\n";
                        $message .= "Thanks,\n";
                        $message .= config('app.name');


                        $user->sendWhatsAppOtpVerification($message);
                        
                    }
                     



                    activity('schedule')
                        ->performedOn($schedule)
                        ->causedBy($user)
                        ->event('email notification')
                        ->withProperties([
                            'schedule_id' => $schedule->id,
                            'name_of_person' => $schedule->name_of_person,
                            'schedule_date' => $schedule->date,
                            'notified_user_email' => $user->email,
                            'triggered_by' => $triggeredBy,
                            'custom_event' => 'email_notification',
                        ])
                        ->log("Funeral reminder sent to {$user->email} for '{$schedule->name_of_person}' on {$schedule->date->format('F j, Y')}.");

                    FuneralScheduleNotification::create([
                        'user_id' => $user->id,
                        'funeral_schedule_id' => $schedule->id,
                        'notified_at' => now(),
                    ]);
                }
            }


        }
    }
}
