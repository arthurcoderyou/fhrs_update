<?php

namespace App\Events;

use App\Models\Role;
use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class RoleDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?Role $role;
    public string $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(Role $role = null)
    {
        $this->role = $role;

        $auth_user = Auth::user();
        $userName = $auth_user ? $auth_user->name : 'System';

        if ($this->role) {
            $this->message = "{$userName} has deleted the role '{$this->role->name}'";
        } else {
            $this->message = "{$userName} has deleted multiple roles";
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
            new PrivateChannel('roles'),
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
