<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;
use App\Events\RoleUpdated;
use Illuminate\Support\Facades\Log;

class RoleEdit extends Component
{

    public string $name = '';

    public $role_id;

    public function mount(Role $role){

         

        $this->role_id = $role->id;
        $this->name = $role->name;

    }

    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => [
                'required',
                'string',
                'unique:roles,name,'.$this->role_id,
            ],

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
                'unique:roles,name,'.$this->role_id,
            ],

        ]);

        //save
        $role = Role::where('id',$this->role_id)->first();
        $role->name = $this->name;
        $role->updated_at = now();
        $role->save();
        
        try {
           event(new RoleUpdated($role));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send RoleUpdated event: ' . $e->getMessage(), [
                'role' => $role->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return redirect()->route('role.index');
    }

    
    public function render()
    {
        return view('livewire.role.role-edit')
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
