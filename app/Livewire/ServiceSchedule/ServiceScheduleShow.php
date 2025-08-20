<?php

namespace App\Livewire\ServiceSchedule;

use App\Models\ServiceSchedule;
use Livewire\Component;

class ServiceScheduleShow extends Component
{

    protected $listeners = [
        'serviceScheduleCreated' => 'refreshSchedule',
        'serviceScheduleUpdated' => 'refreshSchedule',
        'serviceScheduleDeleted' => 'refreshSchedule',  
    ];


    public $user_name;
    public $schedule_date;

    public $start_time;
    public $end_time;  

    public $updated_at;
 
    public $service_schedule_id;
 
 

    public function mount(ServiceSchedule $service_schedule){
 

        $this->service_schedule_id = $service_schedule->id;

         

        $this->loadServiceSchedule();
 
 
    }

  
    public function refreshSchedule()
    {
        $this->loadServiceSchedule();
        $this->existingFiles = $this->getExistingFilesProperty();
    }


    public function loadServiceSchedule()
    {
        $service_schedule = ServiceSchedule::with(['user'])->find($this->service_schedule_id);

        // If no funeral schedule found, return early (optional)
        if (!$service_schedule) {
            return;
        }
 

        // Assign basic properties
        $this->user_name = $service_schedule->user->name; 

        // Format dates and times using Carbon
        $this->schedule_date = optional($service_schedule->schedule_date)->format('M d Y'); 
        $this->start_time = optional($service_schedule->start_time)->format('h:i A');
        $this->end_time = optional($service_schedule->end_time)->format('h:i A');

 
        $this->updated_at =  $service_schedule->updated_at;

        
    }




    public function render()
    {
        return view('livewire.service-schedule.service-schedule-show')
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
