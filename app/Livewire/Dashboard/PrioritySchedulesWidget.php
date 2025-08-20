<?php

namespace App\Livewire\Dashboard;

use App\Models\FuneralSchedule;
use Livewire\Component;

class PrioritySchedulesWidget extends Component
{

    protected $listeners = [
        'funeralScheduleCreated' => '$refresh',
        'funeralScheduleUpdated' => '$refresh',
        'funeralScheduleDeleted' => '$refresh',
        'dashboardUpdated' => '$refresh', 
    ];

    public function getSchedulesProperty(){

        return FuneralSchedule::whereDate('date',now())->get();

    }

    public function render()
    {
        // dd(now());
        // dd($this->schedules);
        return view('livewire.dashboard.priority-schedules-widget',[
            'schedules' => $this->schedules
        ]);
    }
}
