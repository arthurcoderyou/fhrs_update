<?php

namespace App\Livewire\ActivityLog;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Events\ActivityLogDeleted;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class ActivityLogIndex extends Component
{   

    use WithFileUploads;
    use WithPagination;

    protected $listeners = [
        'userCreated' => '$refresh',
        'userUpdated' => '$refresh',
        'userDeleted' => '$refresh', 
        'logDeleted' => '$refresh', 
        'roleCreated' => '$refresh',
        'roleUpdated' => '$refresh',
        'roleDeleted' => '$refresh',  
        'rolePermissionUpdated' => '$refresh',  
        'permissionCreated' => '$refresh',
        'permissionUpdated' => '$refresh',
        'permissionDeleted' => '$refresh',
        'funeralScheduleCreated' => '$refresh',
        'funeralScheduleUpdated' => '$refresh',
        'funeralScheduleDeleted' => '$refresh', 
        'settingCreated' => 'refresh',
        'settingUpdated' => 'refresh',
        'settingDeleted' => 'refresh',   
    ];

    /** Table Filters & Functions */
        
        public $search = '';
        public $sort_by = '';

        public $sortField = 'created_at';      // Default field
        public $sortDirection = 'desc';        // Default direction 

        public $sort_filters = [
            "Latest Added",
            "Oldest Added",
            "Latest Updated",
            "Oldest Updated",
            "Causer A - Z",
            "Causer Z - A",
            "Event A - Z",
            "Event Z - A",
        ];
        
        public $sort_map = [
            "Latest Added"     => ['column' => 'created_at', 'direction' => 'desc'],
            "Oldest Added"     => ['column' => 'created_at', 'direction' => 'asc'],
            "Latest Updated"   => ['column' => 'updated_at', 'direction' => 'desc'],
            "Oldest Updated"   => ['column' => 'updated_at', 'direction' => 'asc'],
            "Causer A - Z"     => ['column' => 'causer_id', 'direction' => 'asc'],  // optional join sort
            "Causer Z - A"     => ['column' => 'causer_id', 'direction' => 'desc'],
            "Event A - Z"      => ['column' => 'event', 'direction' => 'asc'],
            "Event Z - A"      => ['column' => 'event', 'direction' => 'desc'],
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
                $this->selected_records = Activity::pluck('id')->toArray(); // Select all records
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


    public $selected_role;
    public $roles;

    public $account_password;
    public $account_password_verified = false;
 
    public $selected_record = 0;


    public function delete($id)
    { 
 
        $log = Activity::where('id',$id)->first(); 
        $log->delete(); 

        ;

        try {
            event(new ActivityLogDeleted($log));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send ActivityLogDeleted event: ' . $e->getMessage(), [
                'log' => $log->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

    }


    public function deleteAll(){
      
        // User::whereIn('id', $this->selected_records)->delete();

        if(!empty($this->selected_records)){
            foreach($this->selected_records as $selected_record_id){
                $log = Activity::find($selected_record_id);

                $log->delete();

            }
        }

        $this->selected_records = []; // Reset the selected records array
         
         

        try {
            event(new ActivityLogDeleted());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send ActivityLogDeleted event: ' . $e->getMessage(), [
                'user' => auth()->user()->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

 
    }

    

    public function getLogsProperty(){

        if (isset($this->sort_map[$this->sort_by])) {
            $this->sortField = $this->sort_map[$this->sort_by]['column'];
            $this->sortDirection = $this->sort_map[$this->sort_by]['direction'];
        }
    
        return Activity::query()
            ->with('causer')
            ->when($this->search, fn($query) =>
                $query->where('description', 'like', "%{$this->search}%")
                      ->orWhereHas('causer', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->record_count);

 
    }


    public function render()
    {
        return view('livewire.activity-log.activity-log-index',[
            'activity_logs' => $this->logs,
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
