<?php

namespace App\Events;

use App\Models\SettingOptions;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class SettingValueUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?SettingOptions $setting_option;
    public string $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(SettingOptions $setting_option)
    {
        $this->setting_option = $setting_option;

        $auth_user = Auth::user();

        if ($this->setting_option) {
            $this->message =  "{$auth_user->name} has updated the setting option '{$this->setting_option->name}'";
        } else{ 
            $this->message = "{$auth_user->name} has updated multiple setting options ";
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
            new PrivateChannel('setting_options'),
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
