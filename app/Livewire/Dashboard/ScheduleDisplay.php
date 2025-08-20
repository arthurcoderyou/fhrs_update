<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use App\Models\Setting;
use Livewire\Component;
use App\Models\FuneralSchedule;

class ScheduleDisplay extends Component
{   

    protected $listeners = [
        'funeralScheduleCreated' => 'refreshSchedule',
        'funeralScheduleUpdated' => 'refreshSchedule',
        'dashboardUpdated' => 'refreshSchedule',
        'funeralScheduleDeleted' => 'refreshSchedule',  
        // 'settingCreated' => 'refreshSchedule',
        'settingUpdated' => 'refreshSchedule',
        // 'settingDeleted' => 'refreshSchedule',  
    ];


    public $name_of_person;
    public $date;

    public $mass_time;
    public $public_viewing_start;
    public $public_viewing_end;
    public $family_viewing_start;
    public $family_viewing_end;
    public $burial_cemetery;
    public $burial_location;
    public $hearse;
    public $funeral_director;
    public $co_funeral_director;

    public $updated_at;

    public array $familyArrivals = [];
    public array $flowers = [];

    public array $equipments = [];

    public array $familyPointOfContact = [ ];

    public $funeral_schedule_id;

    public $hospice_schedule;

    public array $existingFiles = [];   // existing attachment files for the funeral schedule


    public array $positions = [];

    public array $data = [];


    public $font_size;

    // data on each option
    // public array $data = [
    //     'name_of_person' => 'John Doe',
    //     'date' => 'May 29 2025',
    //     'mass_time' => '12:00 PM',
    //     'public_viewing' => '12:00 PM to 03:00 PM',
    //     'family_viewing' => '12:00 PM to 02:00 PM',
    //     'burial_cemetery' => 'Phil Cemetery',
    //     'burial_location' => 'PH',
    //     'hearse' => 'Wagon Class A',
    //     'funeral_director' => 'Arnold',
    //     'co_funeral_director' => 'Mark Rode',
    //     'family_arrival' => [
    //         '10:00 AM Mother Arrived',
    //         '12:00 PM Father Arrived',
    //         '12:00 PM Sister Arrived',
    //     ],
    //     'flowers' => [  
    //         'Blue Flower',
    //         'Yellow Flower',
    //         'Purple Flower',
    //     ],
    //     'equipments' => [  
    //         'Tent',
    //         'Carousel',
    //         'Cords',
    //     ],
    //     'attachments' => [  
    //         'Tent',
    //         'Carousel',
    //         'Cords',
    //     ],

    // ];


    /**  Display Settings */

        /** Card Settings */
            public $paddingLeft = 2;
            public $paddingRight = 2;
            public $paddingTop = 2;
            public $paddingBottom = 2;

            public $marginLeft = 2;
            public $marginRight = 2;
            public $marginTop = 2;
            public $marginBottom = 2;
        /** ./ Card Settings */


        /** Label and Text Display Settings */
            /** Label */
                public $labelSize = 16;
                public $labelLineHeight = 16;

                public $labelColor = '#000000';
                public $labelFontWeight = 'bold';
                public $labelFontStyle = 'normal';

                public $labelLetterSpacing = '0.5px';

            /** ./ Label */

            /** Text  */
                public $valueSize = 16;
                public $valueLineHeight = 16;

                public $valueColor = '#333333';
                public $valueFontWeight = 'normal';
                public $valueFontStyle = 'normal';
                public $valueLetterSpacing = '0.5px';

            /** ./ Text  */
            
        /** ./ Label and Text Display Settings */

 
    /** ./ Display Settings */



    public function mount(FuneralSchedule $funeral_schedule){
 
          // Set default date as today in mm dd yyyy format
        //    $this->date_range = Carbon::now()->format('m d Y');
        $this->updateDateRange();
       

        $this->funeral_schedule_id = $funeral_schedule->id;

         

        $this->loadFuneralSchedule();

        $this->existingFiles = $this->getExistingFilesProperty();
        $this->positions = $this->getPositionsProperty();
        // $this->font_size = $this->getFontSizeSetting();
        $this->getDisplaySettings();


        // dd($this->data);

        // dd($this->positions);

        // $this->name_of_person = $funeral_schedule->name_of_person;

        // $this->burial_cemetery = $funeral_schedule->burial_cemetery;
        // $this->burial_location = $funeral_schedule->burial_location;
        // $this->hearse = $funeral_schedule->hearse;
        // $this->funeral_director = $funeral_schedule->funeral_director;
        // $this->co_funeral_director = $funeral_schedule->co_funeral_director;

        // $this->date = optional($funeral_schedule->date)->format('m d Y'); 
        // $this->mass_time = optional($funeral_schedule->mass_time)->format('h:i A');
        // $this->public_viewing_start = optional($funeral_schedule->public_viewing_start)->format('h:i A');
        // $this->public_viewing_end = optional($funeral_schedule->public_viewing_end)->format('h:i A');
        // $this->family_viewing_start = optional($funeral_schedule->family_viewing_start)->format('h:i A');
        // $this->family_viewing_end = optional($funeral_schedule->family_viewing_end)->format('h:i A');

        // // 👇 Load existing arrivals
        // $this->familyArrivals = $funeral_schedule->familyArrivals->map(function ($arrival) {
        //     return [
        //         'time' =>optional($arrival->time)->format('H:i'), // 💡 key part,
        //         'notes' => $arrival->notes,
        //     ];
        // })->toArray();

        // // 👇 Load existing flowers
        // $this->flowers = $funeral_schedule->flowers->map(function ($flower) {
        //     return [
        //         'name' => $flower->name,
        //         'notes' => $flower->notes,
        //     ];
        // })->toArray();

        // // 👇 Load existing equipments
        // $this->equipments = $funeral_schedule->equipments->map(function ($equipment) {
        //     return [
        //         'name' => $equipment->name,
        //         'notes' => $equipment->notes,
        //     ];
        // })->toArray();


    }



    

    public function getExistingFilesProperty()
    {


        /*
        $funeral_schedule = FuneralSchedule::find($this->funeral_schedule_id);


        if (empty($funeral_schedule->attachments) || $funeral_schedule->attachments->isEmpty()) {
            return [];
        }

        return $funeral_schedule->attachments
            ->sortByDesc('created_at')
            ->groupBy(function ($document) {
                return $document->created_at->format('M d, Y h:i A');
            })
            ->toArray();
            */

 
        $funeral_schedule = FuneralSchedule::find($this->funeral_schedule_id);

        if (empty($funeral_schedule->attachments) || $funeral_schedule->attachments->isEmpty()) {
            return [];
        }

        return $funeral_schedule->attachments
            ->sortByDesc('created_at')
            // ->groupBy(function ($document) {
            //     // return $document->created_at->format('M d, Y h:i A');
            //     return $document->id;
            // })
            // ->map(function ($group) {
            //     return $group->map(function ($document) {
            //         return [
            //             'id' => $document->id,
            //             'attachment' => $document->attachment,
            //             'created_by' => $document->created_by,
            //             'notes' => $document->notes ?? null, // optional if you want to show notes later
            //             // Add more fields if needed
            //         ];
            //     })->toArray();
            // })
             


            ->toArray();
 


    }


    public function getPositionsProperty(){


        // $this->schedule = FuneralSchedule::first();
        // $schedule = $this->schedule;
        $setting = Setting::getPositionSetting();
        $jsonValue = json_decode($setting->value);

        // dd($jsonValue);

        return $jsonValue ?? [
            'name_of_person',
            'date',
            'mass_time',
            'public_viewing',
            'family_viewing',
            'burial_cemetery',
            'burial_location',
            'hearse',
            'funeral_director',
            'co_funeral_director',
            'family_arrival',
            'flowers',
            'equipments',
            'point_of_contact',
            'attachments',
        ];

    }


    public function getDisplaySettings(){

         
        $this->paddingLeft = Setting::getFontSetting('paddingLeft')->value ?? null;
        $this->paddingRight = Setting::getFontSetting('paddingRight')->value ?? null;
        $this->paddingTop = Setting::getFontSetting('paddingTop')->value ?? null;
        $this->paddingBottom = Setting::getFontSetting('paddingBottom')->value ?? null;

        $this->marginLeft = Setting::getFontSetting('marginLeft')->value ?? null;
        $this->marginRight = Setting::getFontSetting('marginRight')->value ?? null;
        $this->marginTop = Setting::getFontSetting('marginTop')->value ?? null;
        $this->marginBottom = Setting::getFontSetting('marginBottom')->value ?? null;

        $this->labelSize = Setting::getFontSetting('labelSize')->value ?? null;
        $this->labelLineHeight = Setting::getFontSetting('labelLineHeight')->value ?? null;
        $this->labelColor = Setting::getFontSetting('labelColor')->value ?? null;
        $this->labelFontWeight = Setting::getFontSetting('labelFontWeight')->value ?? null;
        $this->labelFontStyle = Setting::getFontSetting('labelFontStyle')->value ?? null;
        $this->labelLetterSpacing = Setting::getFontSetting('labelLetterSpacing')->value ?? null;

        $this->valueSize = Setting::getFontSetting('valueSize')->value ?? null;
        $this->valueLineHeight = Setting::getFontSetting('valueLineHeight')->value ?? null;
        $this->valueColor = Setting::getFontSetting('valueColor')->value ?? null;
        $this->valueFontWeight = Setting::getFontSetting('valueFontWeight')->value ?? null;
        $this->valueFontStyle = Setting::getFontSetting('valueFontStyle')->value ?? null;
        $this->valueLetterSpacing = Setting::getFontSetting('valueLetterSpacing')->value ?? null; 

    }



    //  public function getFontSizeSetting(){


    //     // $this->schedule = FuneralSchedule::first();
    //     // $schedule = $this->schedule;
    //     $setting = Setting::getFontSizeSetting();
    //     // $jsonValue = json_decode($setting->value);

    //     // dd($jsonValue);

    //     return $setting->value ??  16;

    // }


    public function refreshSchedule()
    {
        $this->loadFuneralSchedule();
        $this->existingFiles = $this->getExistingFilesProperty();
        $this->positions = $this->getPositionsProperty();
        // $this->font_size = $this->getFontSizeSetting();
        $this->getDisplaySettings();
    }


    public function loadFuneralSchedule()
    {
        $funeral_schedule = FuneralSchedule::with(['familyArrivals', 'flowers', 'equipments'])->find($this->funeral_schedule_id);

        // If no funeral schedule found, return early (optional)
        if (!$funeral_schedule) {
            return;
        }
        $this->name_of_person = $funeral_schedule->name_of_person;
        $this->updated_at =  $funeral_schedule->updated_at;

        $this->data = [
            'name_of_person' => $funeral_schedule->name_of_person,
            'date' => optional($funeral_schedule->date)->format('M d Y'),
            'mass_time' => optional($funeral_schedule->mass_time)->format('h:i A'),
 

            'public_viewing' =>  optional($funeral_schedule->public_viewing_start)->format('h:i A').' to '.optional($funeral_schedule->public_viewing_end)->format('h:i A'),
            'family_viewing' => optional($funeral_schedule->family_viewing_start)->format('h:i A').' to '.optional($funeral_schedule->family_viewing_end)->format('h:i A'), 

            'burial_cemetery' => $funeral_schedule->burial_cemetery,
            'burial_location' => $funeral_schedule->burial_location,
            'hearse' => $funeral_schedule->hearse,
            'funeral_director' => $funeral_schedule->funeral_director,
            'co_funeral_director' => $funeral_schedule->co_funeral_director,
            'family_arrival' => $funeral_schedule->familyArrivals->map(function ($arrival) {
                return [
                    'time' => optional($arrival->time)->format('H:i'),
                    'notes' => $arrival->notes,
                ];
            })->toArray(),
            'flowers' =>$funeral_schedule->flowers->map(function ($flower) {
                return [
                    'name' => $flower->name,
                    'notes' => $flower->notes,
                ];
            })->toArray(),
            'equipments' =>  $funeral_schedule->equipments->map(function ($equipment) {
                return [
                    'name' => $equipment->name,
                    'notes' => $equipment->notes,
                ];
            })->toArray(),

            'point_of_contact' => $funeral_schedule->familyPointOfContact->map(function ($contact) {
                return [
                    'phone' => $contact->phone,
                    'notes' => $contact->notes,
                ];
            })->toArray(),

            'attachments' => $funeral_schedule->attachments->map(function ($attachment) {
                return [
                    'attachment' => $attachment->attachment,
                    // 'attachment_file' => asset('storage/uploads/funeral_attachments/' . $attachment['attachment']),
                     'attachment_file' =>  route('ftp.download', ['id' => $attachment['id']]) ,
                ];
            })->toArray()
            
            // $this->getExistingFilesProperty(),

        ];





    }
    


    




    // public function render()
    // {
    //     return view('livewire.dashboard.schedule-widget');
    // }

    /** Schedule Search */

        public $sort_by = '';

        public $filter_by = 'Today';

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

        // public $scheduleField = "Today";


        public $schedule_filters = [
            'Select Filter',
            'Today',
            'This Week',
            'This Month',
        ];


        // Watch for changes
        public function updatedFilterBy()
        {
            $this->updateDateRange();
        }

        protected function updateDateRange()
        {
            switch ($this->filter_by) {
                case 'Today':
                    $this->date_range = Carbon::now()->format('m d Y');
                    break;

                case 'This Week':
                    $startOfWeek = Carbon::now()->startOfWeek()->format('m d Y');
                    $endOfWeek   = Carbon::now()->endOfWeek()->format('m d Y');
                    $this->date_range = "{$startOfWeek} to {$endOfWeek}";
                    break;

                case 'This Month':
                    $startOfMonth = Carbon::now()->startOfMonth()->format('m d Y');
                    $endOfMonth   = Carbon::now()->endOfMonth()->format('m d Y');
                    $this->date_range = "{$startOfMonth} to {$endOfMonth}";
                    break;
                default: 
                    $this->date_range = '';
                    break;
                    
            }
        }




        public $record_count = 10;
        public $record_count_filters = [
           10,
           20,
           50,
           100,
           200,
        ];

        public string $date_range = '';
        

        public $schedule_search;

        public function search($funeral_schedule_id){

            // redirect to that page 
            return redirect()->route('funeral_schedule.public.show',['funeral_schedule' => $funeral_schedule_id]);

        }

    /** ./ Schedule Search */


    public function render()
    {

       


        $results = FuneralSchedule::select('funeral_schedules.*');
        if (
            (!empty($this->schedule_search) && strlen($this->schedule_search) > 0) || 
            (!empty($this->sortField) && strlen($this->sortField) > 0) || 
            (!empty($this->sortDirection) && strlen($this->sortDirection) > 0) || 
            (!empty($this->date_range) && strlen($this->date_range) > 0)  
            
            ) {
            $search = $this->schedule_search;

            $sortNearest = $this->sort_by === 'Upcoming Schedules';

            if (!$sortNearest && isset($this->sort_map[$this->sort_by])) {
                $this->sortField = $this->sort_map[$this->sort_by]['column'];
                $this->sortDirection = $this->sort_map[$this->sort_by]['direction'];
            }


            // $results = $results->where(function ($query) use ($search) {
            //     $query->where('funeral_schedules.name', 'LIKE', '%' . $search . '%')
            //     ->where('funeral_schedules.name', 'LIKE', '%' . $search . '%')
            //         ;
            // });


            $results = $results->where(function($query) use ($search) {
                $query->where('funeral_schedules.name_of_person', 'LIKE', '%' . $search . '%')
                    ->orWhere('funeral_schedules.burial_cemetery', 'LIKE', '%' . $search . '%')
                    ->orWhere('funeral_schedules.burial_location', 'LIKE', '%' . $search . '%');
                    // ->orWhereHas('creator', function ($query) use ($search) {
                    //     $query->where('users.name', 'LIKE', '%' . $search . '%')
                    //         ->where('users.email', 'LIKE', '%' . $search . '%');
                    // })
                    // ->orWhereHas('updator', function ($query) use ($search) {
                    //     $query->where('users.name', 'LIKE', '%' . $search . '%')
                    //         ->where('users.email', 'LIKE', '%' . $search . '%');
                    // }) 
            })->when($this->date_range, function ($query) {
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
            
            ;


        }
        $results =  $results->limit(10)->get();


        return view('livewire.dashboard.schedule-display',[
            'results' => $results
        ])
         ->layout('layouts.fullscreen'); // <--- This sets the layout!
    }
}
