<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;
use App\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Events\RolePermissionsUpdated;

class RolePermissions extends Component
{
 
    public $role_id;
    public $role;

    public $selected_permissions;

    public function mount(Role $role){

        
        $this->role = $role;
 
        $this->role_id = $role->id;

        $this->selected_permissions = $this->getSelectedPermissionsProperty();

    }


    public function getSelectedPermissionsProperty(){
        return $this->role->permissions->pluck('id')->toArray();
    }

    public function getModulePermissionsProperty(){
        $module_permissions = Permission::all();

        if (!Auth::user()->hasRole('Global Administrator')) {
            $module_permissions = $module_permissions->reject(function ($permission) {
                return $permission->module === 'Permission';
            });
        }

        if (!Auth::user()->hasRole('Global Administrator')) {
            $module_permissions = $module_permissions->reject(function ($permission) {
                return $permission->module === 'Settings';
            });
        }

        $module_permissions = $module_permissions->groupBy('module');

        return  $module_permissions;
    }


    // Method to select/deselect all checkboxes
    public function selectAll($value)
    {
        if ($value) {
            // Select all within the module
            $this->selected_permissions = Permission::pluck('id')->toArray();
        }else{
            $this->selected_permissions = [];
        }
    }

    public function updated($fields){

        $this->validateOnly($fields,[
            'selected_permissions' => 'required|array|min:1', // Ensure it's an array with at least one selection
        ]);

    }

    public function save(){
        $this->validate([
            'selected_permissions' => 'required|array|min:1', // Ensure it's an array with at least one selection
        ]);

        $sync_permissions = [];
        if(!empty($this->selected_permissions)){
            $sync_permissions = Permission::whereIn('id',$this->selected_permissions)->get();
        }

        // Sync permissions (this will remove permissions that are not selected and add the new ones)
        $this->role->syncPermissions($sync_permissions);

 
        $role = Role::where('id',$this->role->id)->first();
        // event(new RolePermissionsUpdated($role));

         try {
           event(new RolePermissionsUpdated($role));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send RoleDeleted event: ' . $e->getMessage(), [
                'role' => $role->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return redirect()->route('role.permissions',['role' => $this->role_id]);




    }


    public function render()
    {
        return view('livewire.role.role-permissions',[
            'selected_permissions' => $this->selectedPermissions,
            'module_permissions' => $this->modulePermissions,
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
