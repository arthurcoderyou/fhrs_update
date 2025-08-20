<?php

namespace App\Livewire\Permission;

use Livewire\Component;
use App\Models\Permission;
use App\Events\PermissionCreated;
use Illuminate\Support\Facades\Log;

class PermissionCreate extends Component
{
    public string $name = '';

    public $module;
     
    public $modules = [
        "Dashboard",
        "Funeral Schedule",
        "Service Schedule",
        "Hospice Schedule",
        "User",
        "Role",
        "Permissions",
        "Settings",
        "Activity Logs", 
    ]; 

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => [
                'required',
                'string',
                'unique:permissions,name',
            ],
            'module' => [
                'required',
            ]

        ]);
    }


    /**
     * Handle an incoming registration request.
     */
    public function save()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name',
            ],
            'module' => [
                'required',
            ]

        ]);

        //save
        $permission = Permission::create([
            'name' => $this->name,
            'module' => $this->module,
        ]);
 
         
        try {
             event(new PermissionCreated($permission));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PermissionCreated event: ' . $e->getMessage(), [
                'permission' => $permission->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return redirect()->route('permission.index');
    }
    public function render()
    {
        return view('livewire.permission.permission-create')
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
