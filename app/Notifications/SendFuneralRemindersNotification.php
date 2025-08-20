<?php

namespace App\Notifications;

use App\Models\FuneralSchedule;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendFuneralRemindersNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $funeralSchedule;
    /**
     * Create a new notification instance.
     */
    public function __construct(FuneralSchedule $funeralSchedule)
    {
        $this->funeralSchedule = $funeralSchedule;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        // return (new MailMessage)
        //     ->line('The introduction to the notification.')
        //     ->action('Notification Action', url('/'))
        //     ->line('Thank you for using our application!');

        $attachments = $this->funeralSchedule->attachments;

        $email = (new MailMessage)
            ->subject("Funeral Schedule Reminder for: {$this->funeralSchedule->name_of_person}")
            ->markdown('emails.funeral-schedule.reminder', [ 
                'notifiable' => $notifiable,
                'funeral_schedule' => $this->funeralSchedule,
                 // Process related models (Family Arrivals, Flowers, Equipments)
                'familyArrivals' => $this->funeralSchedule->familyArrivals->map(function ($arrival) {
                    return [
                        'time' => optional($arrival->time)->format('H:i'),
                        'notes' => $arrival->notes,
                    ];
                })->toArray(),

                'flowers' => $this->funeralSchedule->flowers->map(function ($flower) {
                    return [
                        'name' => $flower->name,
                        'notes' => $flower->notes,
                    ];
                })->toArray(),

                'equipments' => $this->funeralSchedule->equipments->map(function ($equipment) {
                    return [
                        'name' => $equipment->name,
                        'notes' => $equipment->notes,
                    ];
                })->toArray(),


                'url' => route('funeral_schedule.show', $this->funeralSchedule->id),
            ]);


        

        if( $notifiable->hasRole('Global Administrator') || $notifiable->can('funeral schedule download attachments') ){
           

            // Attach project files if any
            foreach ($attachments as $attachment) {
                $path = storage_path("app/public/uploads/funeral_attachments/{$attachment->attachment}");
                if (file_exists($path)) {
                    $email->attach($path);
                }
            } 
        }

        return $email;


    }

    /**
    //  * Get the array representation of the notification.
    //  *
    //  * @return array<string, mixed>
    //  */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
