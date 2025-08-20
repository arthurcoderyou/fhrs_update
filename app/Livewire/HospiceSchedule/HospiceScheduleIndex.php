<?php

namespace App\Livewire\HospiceSchedule;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HospiceSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Events\HospiceScheduleDeleted;

class HospiceScheduleIndex extends Component
{

    use WithFileUploads;
    use WithPagination;

    protected $listeners = [
        'hospiceScheduleCreated' => '$refresh',
        'hospiceScheduleUpdated' => '$refresh',
        'hospiceScheduleDeleted' => '$refresh',  
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
                $this->selected_records = HospiceSchedule::pluck('id')->toArray(); // Select all records
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

    /** Table Filters & Functions : Funeral Schedules only */
        public string $date_range = '';
    
    /** ./ Table Filters & Functions : Funeral Schedules only */

    public function delete($id)
    { 
 
        $record = HospiceSchedule::where('id',$id)->first(); 
        $record->delete(); 

        

        try {
            event(new HospiceScheduleDeleted($record));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send HospiceScheduleDeleted event: ' . $e->getMessage(), [
                'record' => $record->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }



    }


    public function deleteAll(){
      
        // User::whereIn('id', $this->selected_records)->delete();

        if(!empty($this->selected_records)){
            foreach($this->selected_records as $selected_record_id){
                $record = HospiceSchedule::find($selected_record_id);

                $record->delete();

            }
        }

        $this->selected_records = []; // Reset the selected records array
         
        
        
        try {
            event(new HospiceScheduleDeleted());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send HospiceScheduleDeleted event: ' . $e->getMessage(), [
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

    

    public function getSchedulesProperty(){

        if (isset($this->sort_map[$this->sort_by])) {
            $this->sortField = $this->sort_map[$this->sort_by]['column'];
            $this->sortDirection = $this->sort_map[$this->sort_by]['direction'];
        }
    
        return HospiceSchedule::query() 
            ->when($this->search, callback: fn($query) =>
                    $query->where('name', 'like', "%{$this->search}%")

                        //   ->orWhereHas('causer', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            )
            ->when($this->date_range, function ($query) {
                $dates = explode(' to ', $this->date_range);
                try {
                    if (count($dates) === 2) {
                        $start = Carbon::createFromFormat('m d Y', trim($dates[0]))->startOfDay();
                        $end = Carbon::createFromFormat('m d Y', trim($dates[1]))->endOfDay();
                    } elseif (count($dates) === 1) {
                        $start = Carbon::createFromFormat('m d Y', trim($dates[0]))->startOfDay();
                        $end = Carbon::createFromFormat('m d Y', trim($dates[0]))->endOfDay();
                    } else {
                        return;
                    }

                    // Check if the schedule period overlaps with the selected range
                    $query->where(function ($q) use ($start, $end) {
                        $q->whereBetween('start_date', [$start, $end])
                        ->orWhereBetween('end_date', [$start, $end])
                        ->orWhere(function ($q2) use ($start, $end) {
                            $q2->where('start_date', '<=', $start)
                                ->where('end_date', '>=', $end);
                        });
                    });

                } catch (\Exception $e) {
                    $this->addError('date', 'The date format is invalid. Please use MM DD YYYY.');
                    return;
                }
            })  
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->record_count);

 
    }


  

    public function render()
    {
        return view('livewire.hospice-schedule.hospice-schedule-index',[
            'hospice_schedules' => $this->schedules
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
        // ;
    }
}
