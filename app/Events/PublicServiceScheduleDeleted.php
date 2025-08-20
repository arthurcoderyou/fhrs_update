<?php

namespace App\Events;

use App\Models\ServiceSchedule;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PublicServiceScheduleDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?ServiceSchedule $service_schedule;
    public string $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(ServiceSchedule $service_schedule = null)
    {
        $this->service_schedule = $service_schedule;

        $auth_user = Auth::user();
        $userName = $auth_user ? $auth_user->name : 'System';

        if ($this->service_schedule) {
            $this->message = "{$userName} has deleted the service schedule for '{$this->service_schedule->name_of_person}'";
        } else {
            $this->message = "{$userName} has deleted multiple service schedules";
        }

         
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('service_schedules'),
        ];
    }

    public function broadcastAs(){
        return "deleted";
    }


    public function broadcastWith(){
         
        
        return [
            'message' => $this->message,
             
        ];
    }
}
