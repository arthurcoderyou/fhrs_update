<?php

namespace App\Livewire\FuneralSchedule;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\FuneralSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Events\FuneralScheduleDeleted; 
use App\Events\PublicFuneralScheduleDeleted;

class FuneralScheduleIndex extends Component
{

    use WithFileUploads;
    use WithPagination;

    protected $listeners = [
        'funeralScheduleCreated' => '$refresh',
        'funeralScheduleUpdated' => '$refresh',
        'funeralScheduleDeleted' => '$refresh',  
    ];

    /** Table Filters & Functions */
        
        public $search = '';
        public $sort_by = '';

        public $sortField = 'updated_at';      // Default field
        public $sortDirection = 'desc';        // Default direction 

        public $sort_filters = [
            "Upcoming Schedules",
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
            "Name A - Z"     => ['column' => 'name_of_person', 'direction' => 'asc'],   
            "Name Z - A"     => ['column' => 'name_of_person', 'direction' => 'desc'], 
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
                $this->selected_records = FuneralSchedule::pluck('id')->toArray(); // Select all records
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



    public function delete($id)
    { 
 
        $user = Auth::user();

        if (!$user || (!$user->hasRole('Global Administrator') && !$user->can('funeral schedule delete'))) {
            // // For error message
            // session()->flash('alert.error', 'You do not have permission to download this file');
            // /// If this component uses WithPagination:
            // $this->resetPage();

            // // Re-render THIS component
            // $this->dispatch('$refresh');
            // return;

            // calls the notify event with the type of notification and the message
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to delete records');
            return;

            
        }

        // session()->flash('alert.error', 'You do not have permission to download this file');

        $record = FuneralSchedule::where('id',$id)->first(); 

        


        $record->delete(); 

        
        try {
            event(new FuneralScheduleDeleted($record));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send FuneralScheduleDeleted event: ' . $e->getMessage(), [
                'record' => $record->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        try {
            event(new PublicFuneralScheduleDeleted($record));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicFuneralScheduleDeleted event: ' . $e->getMessage(), [
                'record' => $record->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


    }


    public function deleteAll(){


        $user = Auth::user();

        if (!$user || (!$user->hasRole('Global Administrator') && !$user->can('funeral schedule delete'))) {
             

            // calls the notify event with the type of notification and the message
            $this->dispatch('notify', type: 'error', message: 'You do not have permission to delete records');
            return;

            
        }

      
        // User::whereIn('id', $this->selected_records)->delete();

        if(!empty($this->selected_records)){
            foreach($this->selected_records as $selected_record_id){
                $record = FuneralSchedule::find($selected_record_id);

                $record->delete();

            }
        }

        $this->selected_records = []; // Reset the selected records array
         
        

        try {
            event(new FuneralScheduleDeleted());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send FuneralScheduleDeleted event: ' . $e->getMessage(), [
                'auth' => auth()->user()->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        try {
            event(new PublicFuneralScheduleDeleted());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicFuneralScheduleDeleted event: ' . $e->getMessage(), [
                'auth' => auth()->user()->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

 
    }

    public function getSchedulesProperty(){

        $sortNearest = $this->sort_by === 'Upcoming Schedules';

        if (!$sortNearest && isset($this->sort_map[$this->sort_by])) {
            $this->sortField = $this->sort_map[$this->sort_by]['column'];
            $this->sortDirection = $this->sort_map[$this->sort_by]['direction'];
        }
    
        return FuneralSchedule::query() 
            ->when($this->search, callback: fn($query) =>
                $query->where('name_of_person', 'like', "%{$this->search}%")

                    //   ->orWhereHas('causer', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            )
            ->when($this->date_range, function ($query) {
                $dates = explode(' to ', $this->date_range);
                try {
                    if (count($dates) === 2) {
                        $start = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
                        $end = Carbon::createFromFormat('m d Y', $dates[1])->endOfDay();
                    } elseif (count($dates) === 1) {
                        $start = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
                        $end = Carbon::createFromFormat('m d Y', $dates[0])->endOfDay();
                    } else {
                        return;
                    }

                    $query->whereBetween('date', [$start, $end]);

                } catch (\Exception $e) {
                    $this->addError('date', 'The date format is invalid. Please use MM DD YYYY.');
                    return;
                }
            })
            ->when($sortNearest, fn($q) =>
                $q->orderByRaw('ABS(DATEDIFF(date, ?))', [now()])
            )
            ->when(!$sortNearest && !empty($this->sortField), fn($q) =>
                $q->orderBy($this->sortField, $this->sortDirection)
            )
            ->paginate($this->record_count);

 
    }


    public function render()
    {
        return view('livewire.funeral-schedule.funeral-schedule-index',[
            'funeral_schedules' => $this->schedules,
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
