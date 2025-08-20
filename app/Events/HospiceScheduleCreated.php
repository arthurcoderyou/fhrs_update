<?php

namespace App\Events;

use App\Models\HospiceSchedule;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
 
class HospiceScheduleCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?HospiceSchedule $hospice_schedule;
    public string $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(HospiceSchedule $hospice_schedule)
    {
        $this->hospice_schedule = $hospice_schedule;

        $auth_user = Auth::user();
        $userName = $auth_user ? $auth_user->name : 'System';

        if ($this->hospice_schedule) {
            $this->message = "{$userName} has created the hospice schedule for '{$this->hospice_schedule->name}'";
        } else {
            $this->message = "{$userName} has created multiple hospice schedules";
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
            new PrivateChannel('hospice_schedules'),
        ];
    }

    public function broadcastAs(){
        return "created";
    }


    public function broadcastWith(){
         
        
        return [
            'message' => $this->message,
             
        ];
    }
}
