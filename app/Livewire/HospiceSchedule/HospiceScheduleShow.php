<?php

namespace App\Livewire\HospiceSchedule;

use Livewire\Component;
use App\Models\HospiceSchedule;

class HospiceScheduleShow extends Component
{   

    protected $listeners = [
        'hospiceScheduleCreated' => 'refreshSchedule',
        'hospiceScheduleUpdated' => 'refreshSchedule',
        'hospiceScheduleDeleted' => 'refreshSchedule',  
    ];


    public $name;
    public $start_date;
    public $end_date;

    public $updated_at;
  
    public string $date_range = '';

    public int $hospice_schedule_id;
    public HospiceSchedule $hospice_schedule; 

    public function mount(HospiceSchedule $hospice_schedule){
 
        $this->hospice_schedule = $hospice_schedule;

        $this->loadHospiceSchedule();
    }

    public function refreshSchedule()
    {
        $this->loadHospiceSchedule();
    }



    public function loadHospiceSchedule()
    {
 
        $this->hospice_schedule_id = $this->hospice_schedule->id;
        $this->name = $this->hospice_schedule->name; 
        $this->date_range = optional($this->hospice_schedule->start_date)->format('M d Y').' to '. optional($this->hospice_schedule->end_date)->format('M d Y');  

        $this->updated_at = $this->hospice_schedule->updated_at; 
    }

    
    
    public function render()
    {
        return view('livewire.hospice-schedule.hospice-schedule-show')->layout('layouts.app');
    }
}
