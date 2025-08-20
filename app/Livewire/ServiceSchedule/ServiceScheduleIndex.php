<?php

namespace App\Livewire\ServiceSchedule;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ServiceSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Events\ServiceScheduleDeleted;
use App\Events\PublicServiceScheduleDeleted;

class ServiceScheduleIndex extends Component
{

    use WithFileUploads;
    use WithPagination;

    protected $listeners = [
        'serviceScheduleCreated' => '$refresh',
        'serviceScheduleUpdated' => '$refresh',
        'serviceScheduleDeleted' => '$refresh',  
    ];

    /** Table Filters & Functions */
        
        public $search = '';
        public $sort_by = '';

        public $sortField = 'updated_at';      // Default field
        public $sortDirection = 'desc';        // Default direction 

        public $sort_filters = [
            // "Upcoming Schedules",
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
                $this->selected_records = ServiceSchedule::query()
                    ->when($this->search, callback: fn($query) =>
                        $query->whereHas('user', fn($q) => 
                                    $q->where('name', 'like', "%{$this->search}%")  
                                        ->orWhere('email', 'like', "%{$this->search}%")
                                )
                                ->orWhereHas('creator', fn($q) => 
                                    $q->where('name', 'like', "%{$this->search}%")
                                        ->orWhere('email', 'like', "%{$this->search}%")
                                )
                    )
                    ->where(function ($query) {
                        // Handle non-recurring schedules
                        $query->when($this->start_date && $this->end_date, function ($q) {
                                $start = Carbon::parse($this->start_date)->startOfDay();
                                $end = Carbon::parse($this->end_date)->endOfDay();
        

                                $q->whereBetween('schedule_date', [$start, $end]); 


                            });

                        
                    })
                    ->pluck('id')->toArray(); // Select all records
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
        public $start_date;
        public $end_date;
    
    /** ./ Table Filters & Functions : Funeral Schedules only */

    public function delete($id)
    { 
 
        $record = ServiceSchedule::where('id',$id)->first(); 

        


        $record->delete(); 

        // event(new FuneralScheduleDeleted($record));

        try {
           event(new ServiceScheduleDeleted($record));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send ServiceScheduleDeleted event: ' . $e->getMessage(), [
                'record' => $record->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        try {
           event(new PublicServiceScheduleDeleted($record));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicServiceScheduleDeleted event: ' . $e->getMessage(), [
                'record' => $record->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


    }


    public function deleteAll(){
      
        // User::whereIn('id', $this->selected_records)->delete();

        if(!empty($this->selected_records)){
            foreach($this->selected_records as $selected_record_id){
                $record = ServiceSchedule::find($selected_record_id);

                $record->delete();

            }
        }

        $this->selected_records = []; // Reset the selected records array
         
        try {
           event(new ServiceScheduleDeleted());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send ServiceScheduleDeleted event: ' . $e->getMessage(), [
                'auth' => auth()->user()->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


        try {
           event(new PublicServiceScheduleDeleted());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicServiceScheduleDeleted event: ' . $e->getMessage(), [
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

         

        $sortNearest = $this->sort_by === 'Upcoming Schedules';

        if (!$sortNearest && isset($this->sort_map[$this->sort_by])) {
            $this->sortField = $this->sort_map[$this->sort_by]['column'];
            $this->sortDirection = $this->sort_map[$this->sort_by]['direction'];
        }


        
        // dd( $this->date_range);

        if(!empty($this->date_range)){
            $dates = explode(' to ', $this->date_range);

            try {
                if (count($dates) === 2) {
                    $this->start_date = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
                    $this->end_date = Carbon::createFromFormat('m d Y', $dates[1])->endOfDay();
                } elseif (count($dates) === 1) {
                    $this->start_date = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
                    $this->end_date = Carbon::createFromFormat('m d Y', $dates[0])->endOfDay();
                } else {
                    return;
                }

                    
            } catch (\Exception $e) {
                $this->addError('date', 'The date format is invalid. Please use MM DD YYYY.');
                return;
            }

        }
    
        return ServiceSchedule::query() 
            ->when($this->search, callback: fn($query) =>
                $query->whereHas('user', fn($q) => 
                            $q->where('name', 'like', "%{$this->search}%")  
                                ->orWhere('email', 'like', "%{$this->search}%")
                        )
                        ->orWhereHas('creator', fn($q) => 
                            $q->where('name', 'like', "%{$this->search}%")
                                ->orWhere('email', 'like', "%{$this->search}%")
                        )
            )
            ->where(function ($query) {
                // Handle non-recurring schedules
                $query->when($this->start_date && $this->end_date, function ($q) {
                        $start = Carbon::parse($this->start_date)->startOfDay();
                        $end = Carbon::parse($this->end_date)->endOfDay();
 

                        $q->whereBetween('schedule_date', [$start, $end]); 


                    });

                
            })
             
            ->when(!$sortNearest && !empty($this->sortField), fn($q) =>
                $q->orderBy($this->sortField, $this->sortDirection)
            )
            ->paginate($this->record_count);

 
    }

    public function getCalendarEvents()
    {
 
        return ServiceSchedule::query()
            ->when($this->search, callback: fn($query) =>
                    $query->whereHas('user', fn($q) => 
                                $q->where('name', 'like', "%{$this->search}%")  
                                    ->orWhere('email', 'like', "%{$this->search}%")
                            )
                            ->orWhereHas('creator', fn($q) => 
                                $q->where('name', 'like', "%{$this->search}%")
                                    ->orWhere('email', 'like', "%{$this->search}%")
                            )
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

                    $query->whereBetween('schedule_date', [$start, $end]);

                } catch (\Exception $e) {
                    $this->addError('schedule_date', 'The date format is invalid. Please use MM DD YYYY.');
                    return;
                }
            })
            ->limit(200)
            ->get() 
            ->map(function ($schedule) {

                  // If start_time and end_time are full datetime already:
                    $startTimestamp = Carbon::parse($schedule->start_time);
                    $endTimestamp = Carbon::parse($schedule->end_time);
                    

                // dd(now());
                
                return [
                    'title' => $schedule->user->name,
                    // 'title' => "{$schedule->name_of_person} - Mass: {$schedule->mass_time}, Cemetery: {$schedule->burial_cemetery}, Location: {$schedule->burial_location}",
                    // 'full_description' => '{$schedule->name_of_person}\nMass: {$schedule->mass_time}\nCemetery: {$schedule->burial_cemetery}\nLocation: {$schedule->burial_location}',
                    'desc' => 'Scheduled from ' .
                        Carbon::parse($schedule->start_time)->format('g:i A') . ' to ' .
                        Carbon::parse($schedule->end_time)->format('g:i A'),
                    
                    'start' => $startTimestamp->toIso8601String(),
                    'end' => $endTimestamp->toIso8601String(),


                    'url' => route('service_schedule.edit', $schedule->id), // optional

                    // 'start' => $schedule->date . 'T' . $schedule->mass_time, // combine date and time
                    // 'extendedProps' => [
                    //     'burial_cemetery' => $schedule->burial_cemetery,
                    //     'burial_location' => $schedule->burial_location,
                    // ],


                ];
        });
    }


    public function render()
    {

        $calendarEvents = $this->getCalendarEvents();

        $this->dispatch('calendarEventsUpdated', events: $calendarEvents);


        // dd($this->schedules);
        return view('livewire.service-schedule.service-schedule-index',[
            'service_schedules' => $this->schedules,
            'calendar_events' => $this->getCalendarEvents(),
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
