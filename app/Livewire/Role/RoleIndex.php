<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;
use App\Events\RoleDeleted;
use App\Events\RoleUpdated;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RoleIndex extends Component
{


    use WithFileUploads;
    use WithPagination;

    protected $listeners = [
        'roleCreated' => '$refresh',
        'roleUpdated' => '$refresh',
        'roleDeleted' => '$refresh',  
        'rolePermissionUpdated' => '$refresh',  
    ];

    /** Table Filters & Functions */
        
        public $search = '';
        public $sort_by = '';

        public $sortField = 'updated_at';      // Default field
        public $sortDirection = 'desc';        // Default direction 

        public $sort_filters = [
            "Latest Added",
            "Oldest Added",
            "Latest Updated",
            "Oldest Updated",
            "Name A - Z",
            "Name Z - A", 
        ];
        
        public $sort_map = [
            "Latest Added"     => ['column' => 'created_at', 'direction' => 'desc'],
            "Oldest Added"     => ['column' => 'created_at', 'direction' => 'asc'],
            "Latest Updated"   => ['column' => 'updated_at', 'direction' => 'desc'],
            "Oldest Updated"   => ['column' => 'updated_at', 'direction' => 'asc'],
            "Name A - Z"     => ['column' => 'name', 'direction' => 'asc'],   
            "Name Z - A"     => ['column' => 'name', 'direction' => 'desc'], 
        ];


        public $record_count = 10;
        public $record_count_filters = [
           10,
           20,
           50,
           100,
           200,
        ];

 
        public $selected_records = [];
        public $selectAll = false;

        public $count = 0;


        public function toggleSelectAll()
        {
            if ($this->selectAll) {
                $this->selected_records = Role::pluck('id')->toArray(); // Select all records
            } else {
                $this->selected_records = []; // Deselect all
            }

            $this->count = count($this->selected_records);
        }

        public function updateSelectedCount()
        {
            // Update the count when checkboxes are checked or unchecked
            $this->count = count($this->selected_records);
        }



    /** ./ Table Filters & Functions */



    public $rolesCannotBeDeleted = [
        "User", 
        "Scheduler",
        "Administrator",
        "Global Administrator",
        "Subscriber",
    ];



    public function delete($id)
    { 
        
        if (!auth()->user()->roles->pluck('name')->contains('Global Administrator')) {
            return session()->flash('error', 'You are not authorized to delete roles.');
        }
        
        


        $role = Role::where('id',$id)->first(); 


        // Restrict deletion of specific role names
        if (in_array($role->name, $this->rolesCannotBeDeleted) && !Auth::user()->hasRole('Global Administrator')) {
            return session()->flash('error', "The role '{$role->name}' cannot be deleted.");
        }


        $role->delete(); 
 

         try {
           event(new RoleDeleted($role));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send RoleDeleted event: ' . $e->getMessage(), [
                'role' => $role->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


    }


    public function deleteAll(){
      
        // User::whereIn('id', $this->selected_records)->delete();

        if(!empty($this->selected_records)){
            foreach($this->selected_records as $selected_record_id){
                $role = Role::find($selected_record_id);

                $role->delete();

            }
        }

        $this->selected_records = []; // Reset the selected records array
          
          try {
           event(new RoleDeleted( ));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send RoleDeleted event: ' . $e->getMessage(), [
                'auth' => auth()->user()->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


 
    }


    /** Actions with Password Confirmation panel */
        public $passwordConfirm = '';
        public $passwordError = null;


        /** Delete Confirmation  */
            public $confirmingDelete = false; // closes the confirmation delete panel
            
            public $recordId = null; 
            public function confirmDelete($recordId)
            {
                $this->confirmingDelete = true;
                $this->recordId = $recordId;
                $this->passwordConfirm = '';
                $this->passwordError = null;
            }

            public function executeDelete()
            {
                if (!Hash::check($this->passwordConfirm, auth()->user()->password)) {
                    $this->passwordError = 'Incorrect password.';
                    return;
                }
 
                // delete the record
                $this->delete($this->recordId);

                $this->reset(['confirmingDelete', 'passwordConfirm', 'recordId', 'passwordError']); 
            }

        /** ./ Delete Confirmation */

    /** ./ Actions with Password Confirmation panel */


    public function getRolesProperty(){

        if (isset($this->sort_map[$this->sort_by])) {
            $this->sortField = $this->sort_map[$this->sort_by]['column'];
            $this->sortDirection = $this->sort_map[$this->sort_by]['direction'];
        }
    
        return Role::query() 
            ->when($this->search, callback: fn($query) =>
                $query->where('name', 'like', "%{$this->search}%")

                    //   ->orWhereHas('causer', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            )
            ->when(!auth()->user()->hasRole('Global Administrator'), function ($query) {
                $query->where('name', '!=', 'Global Administrator');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->record_count);

 
    }


    public function render()
    {
        return view('livewire.role.role-index',[
            'roles' => $this->roles,
        ])
            ->layout('layouts.app'); // <--- This sets the layout!
    }
}
