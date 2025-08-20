<?php

namespace App\Livewire\FuneralSchedule;

use Livewire\Component;
use App\Models\FuneralSchedule;

class FuneralScheduleShow extends Component
{

    protected $listeners = [
        'funeralScheduleCreated' => 'refreshSchedule',
        'funeralScheduleUpdated' => 'refreshSchedule',
        'funeralScheduleDeleted' => 'refreshSchedule',  
    ];


    public $name_of_person;
    public $folder;
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

    public function mount(FuneralSchedule $funeral_schedule){
 

        $this->funeral_schedule_id = $funeral_schedule->id;

         

        $this->loadFuneralSchedule();

        $this->existingFiles = $this->getExistingFilesProperty();


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
    }


    public function refreshSchedule()
    {
        $this->loadFuneralSchedule();
        $this->existingFiles = $this->getExistingFilesProperty();
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
        $this->folder = $funeral_schedule->folder;
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

        // 👇 Load existing family point of contacts 
        $this->familyPointOfContact = $funeral_schedule->familyPointOfContact->map(function ($contact) {
            return [
                'phone' => $contact->phone,
                'notes' => $contact->notes,
            ];
        })->toArray();

    }


    public function render()
    {
        return view('livewire.funeral-schedule.funeral-schedule-show')
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
