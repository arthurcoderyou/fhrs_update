<?php

namespace App\Events;

use App\Models\Role;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Spatie\Activitylog\Facades\Activity as LogActivity;

class RolePermissionsUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?Role $role;
    public string $message;
    
    /**
     * Create a new event instance.
     */
    public function __construct(Role $role)
    {
        $this->role = $role;

        $auth_user = Auth::user();
        $userName = $auth_user ? $auth_user->name : 'System';

        if ($this->role) {
            $this->message = "{$userName} has updated the role permissions for '{$this->role->name}'";
        }  

        // // ✅ Log the activity
        // LogActivity::causedBy($auth_user)
        //     ->performedOn($this->role)
        //     ->useLogName('role')
        //     ->event('permissions_updated') // Custom event name
        //     ->withProperties([
        //         'role_id' => $this->role->id,
        //         'role_name' => $this->role->name,
        //         'ip' => request()->ip(),
        //         'user_agent' => request()->userAgent(),
        //     ])
        //     ->log($this->message);

        activity('role')
            ->causedBy($auth_user)
            ->performedOn($this->role)
            ->event('updated')
            ->withProperties([
                'role_id' => $this->role->id,
                'role_name' => $this->role->name,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ])
            ->log($this->message);

         
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
        return "updated_permissions";
    }


    public function broadcastWith(){
         
        
        return [
            'message' => $this->message,
             
        ];
    }



}
