<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;
use App\Events\RoleCreated;
use Illuminate\Support\Facades\Log;

class RoleCreate extends Component
{


    public string $name = '';


    public function updated($fields){
        $this->validateOnly($fields,[
            'name' => [
                'required',
                'string',
                'unique:roles,name',
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
                'unique:roles,name',
            ],

        ]);

        //save
        $role = Role::create([
            'name' => $this->name,
        ]);
  

        try {
           event(new RoleCreated($role));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send RoleCreated event: ' . $e->getMessage(), [
                'role' => $role->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return redirect()->route('role.index');
    }

    public function render()
    {
        return view('livewire.role.role-create')
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
