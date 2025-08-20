<?php

namespace App\Events;

use App\Models\Permission;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PermissionUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?Permission $permission;
    public string $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(Permission $permission)
    {
        $this->permission = $permission;

        $auth_user = Auth::user();
        $userName = $auth_user ? $auth_user->name : 'System';

        if ($this->permission) {
            $this->message = "{$userName} has updated the permission '{$this->permission->name}'";
        } else {
            $this->message = "{$userName} has updated multiple permissions";
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
            new PrivateChannel('permissions'),
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
