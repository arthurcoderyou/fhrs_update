<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActivityLogDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?Activity $log;
    public string $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(Activity $log = null)
    {
        $this->log = $log;

        $auth_user = Auth::user();

        if ($this->log) {
            $this->message =  "{$auth_user->name} has deleted the log '{$this->log->description}'";
        } else{ 
            $this->message = "{$auth_user->name} has deleted multiple logs";
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
            new PrivateChannel('activity_logs'),
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
