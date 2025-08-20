<?php

namespace App\Livewire\Permission;

use Livewire\Component;
use App\Models\Permission;
use App\Events\PermissionUpdated;
use Illuminate\Support\Facades\Log;

class PermissionEdit extends Component
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

    public $permission_id;

    public function mount(Permission $permission){

         

        $this->permission_id = $permission->id;
        $this->name = $permission->name;
        $this->module = $permission->module;

    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$this->permission_id,
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
                'unique:permissions,name,'.$this->permission_id,
            ],
            'module' => [
                'required',
            ]

        ]);

        //save
        $permission = Permission::where('id',$this->permission_id)->first();
        $permission->name = $this->name;
        $permission->module = $this->module;
        $permission->updated_at = now();
        $permission->save();
         
        try {
             event(new PermissionUpdated($permission));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PermissionUpdated event: ' . $e->getMessage(), [
                'permission' => $permission->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return redirect()->route('permission.index');
    }


    public function render()
    {
        return view('livewire.permission.permission-edit')
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
