<?php

namespace App\Events;

use App\Models\FuneralSchedule;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PublicFuneralScheduleCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public ?FuneralSchedule $funeral_schedule;
    public string $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(FuneralSchedule $funeral_schedule)
    {
        $this->funeral_schedule = $funeral_schedule;

        $auth_user = Auth::user();
        $userName = $auth_user ? $auth_user->name : 'System';

        if ($this->funeral_schedule) {
            $this->message = "{$userName} has created the funeral schedule for '{$this->funeral_schedule->name_of_person}'";
        } else {
            $this->message = "{$userName} has created multiple funeral schedules";
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
            new Channel('funeral_schedules'),
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
