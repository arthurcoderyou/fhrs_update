<?php

namespace App\Livewire\Dashboard;

use App\Models\Setting;
use Livewire\Component;
use App\Models\FuneralSchedule;

class ScheduleWidget extends Component
{

    protected $listeners = [
        'funeralScheduleCreated' => 'refreshSchedule',
        'funeralScheduleUpdated' => 'refreshSchedule',
        'dashboardUpdated' => 'refreshSchedule',
        'funeralScheduleDeleted' => 'refreshSchedule',  
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





    public function mount(FuneralSchedule $funeral_schedule){
 

        $this->funeral_schedule_id = $funeral_schedule->id;

         

        $this->loadFuneralSchedule();

        $this->existingFiles = $this->getExistingFilesProperty();
        $this->positions = $this->getPositionsProperty();
        

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


    public function refreshSchedule()
    {
        $this->loadFuneralSchedule();
        $this->existingFiles = $this->getExistingFilesProperty();
        $this->positions = $this->getPositionsProperty();
    }


    public function loadFuneralSchedule()
    {
        $funeral_schedule = FuneralSchedule::with(['familyArrivals', 'flowers', 'equipments'])->find($this->funeral_schedule_id);

        // If no funeral schedule found, return early (optional)
        if (!$funeral_schedule) {
            return;
        }

        $this->hospice_schedule = $funeral_schedule->hospice_schedule ?? null;
        // dd($this->hospice_schedule);

        // Assign basic properties
        $this->name_of_person = $funeral_schedule->name_of_person;
        $this->burial_cemetery = $funeral_schedule->burial_cemetery;
        $this->burial_location = $funeral_schedule->burial_location;
        $this->hearse = $funeral_schedule->hearse;
        $this->funeral_director = $funeral_schedule->funeral_director;
        $this->co_funeral_director = $funeral_schedule->co_funeral_director;

        // Format dates and times using Carbon
        $this->date = optional($funeral_schedule->date)->format('M d Y');
        $this->mass_time = optional($funeral_schedule->mass_time)->format('h:i A');
        $this->public_viewing_start = optional($funeral_schedule->public_viewing_start)->format('h:i A');
        $this->public_viewing_end = optional($funeral_schedule->public_viewing_end)->format('h:i A');
        $this->family_viewing_start = optional($funeral_schedule->family_viewing_start)->format('h:i A');
        $this->family_viewing_end = optional($funeral_schedule->family_viewing_end)->format('h:i A');
        $this->updated_at =  $funeral_schedule->updated_at;

        // Process related models (Family Arrivals, Flowers, Equipments)
        $this->familyArrivals = $funeral_schedule->familyArrivals->map(function ($arrival) {
            return [
                'time' => optional($arrival->time)->format('H:i'),
                'notes' => $arrival->notes,
            ];
        })->toArray();

        $this->flowers = $funeral_schedule->flowers->map(function ($flower) {
            return [
                'name' => $flower->name,
                'notes' => $flower->notes,
            ];
        })->toArray();

        $this->equipments = $funeral_schedule->equipments->map(function ($equipment) {
            return [
                'name' => $equipment->name,
                'notes' => $equipment->notes,
            ];
        })->toArray();

        $this->familyPointOfContact = $funeral_schedule->familyPointOfContact->map(function ($contact) {
            return [
                'phone' => $contact->phone,
                'notes' => $contact->notes,
            ];
        })->toArray();


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


    public function render()
    {
        return view('livewire.dashboard.schedule-widget');
    }
}
