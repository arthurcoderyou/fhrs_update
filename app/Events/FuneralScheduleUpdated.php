<?php

namespace App\Events;

use App\Models\FuneralSchedule;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class FuneralScheduleUpdated implements ShouldBroadcastNow
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
            $this->message = "{$userName} has updated the funeral schedule for '{$this->funeral_schedule->name_of_person}'";
        } else {
            $this->message = "{$userName} has updated multiple funeral schedules";
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
            new PrivateChannel('funeral_schedules'),
        ];
    }

    public function broadcastAs(){
        return "updated";
    }


    public function broadcastWith(){
         
        
        return [
            'message' => $this->message,
             
        ];
    }
}
