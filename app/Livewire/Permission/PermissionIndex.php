<?php

namespace App\Livewire\Permission;

use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Events\PermissionDeleted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class PermissionIndex extends Component
{

    use WithFileUploads;
    use WithPagination;

    protected $listeners = [
        'permissionCreated' => '$refresh',
        'permissionUpdated' => '$refresh',
        'permissionDeleted' => '$refresh',  
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
                $this->selected_records = Permission::pluck('id')->toArray(); // Select all records
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


    /** Table Filter : Permission Only */
        public $filter_by_module = ''; 
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
    /** ./ Table Filter : Permission Only */


    public function delete($id)
    { 
 
        $record = Permission::where('id',$id)->first(); 
        $record->delete(); 

         

        try {
             event(new PermissionDeleted($record));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PermissionDeleted event: ' . $e->getMessage(), [
                'permission' => $record->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

    }


    public function deleteAll(){
      
        // User::whereIn('id', $this->selected_records)->delete();

        if(!empty($this->selected_records)){
            foreach($this->selected_records as $selected_record_id){
                $record = Permission::find($selected_record_id);

                $record->delete();

            }
        }

        $this->selected_records = []; // Reset the selected records array
         
        // event(new PermissionDeleted());

        try {
            event(new PermissionDeleted());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PermissionDeleted event: ' . $e->getMessage(), [
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
    

    public function getPermissionsProperty(){

        if (isset($this->sort_map[$this->sort_by])) {
            $this->sortField = $this->sort_map[$this->sort_by]['column'];
            $this->sortDirection = $this->sort_map[$this->sort_by]['direction'];
        }
    
        return Permission::query() 
            ->when($this->search, callback: fn($query) =>
                $query->where('name', 'like', "%{$this->search}%")

                    //   ->orWhereHas('causer', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            )
            ->when($this->filter_by_module, callback: fn($query) =>
                $query->where('module',   "{$this->filter_by_module}")

                    //   ->orWhereHas('causer', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->record_count);

 
    }




    public function render()
    {
        return view('livewire.permission.permission-index',[
            'permissions' => $this->permissions,
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
