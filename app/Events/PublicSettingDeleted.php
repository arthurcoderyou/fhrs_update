<?php

namespace App\Events;

use App\Models\Setting;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PublicSettingDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?Setting $setting;
    public string $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;

        $auth_user = Auth::user();

        if ($this->setting) {
            $this->message =  "{$auth_user->name} has deleted the setting '{$this->setting->name}'";
        } else{ 
            $this->message = "{$auth_user->name} has deleted multiple settings";
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
            new Channel('settings'),
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
