<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\FuneralSchedule;

class FuneralSchedulesWidget extends Component
{
    protected $listeners = [
        'funeralScheduleCreated' => '$refresh',
        'funeralScheduleUpdated' => '$refresh',
        'funeralScheduleDeleted' => '$refresh',  
        'dashboardUpdated' => '$refresh',
    ];
    
    public $record_count = 20;
    public function getSchedulesProperty(){ 
    
        return FuneralSchedule::query()
            ->whereDate('date', '>=', now()->toDateString()) // Only future or today
            ->orderBy('date', 'asc') // Nearest first
            ->paginate($this->record_count);
 
    }


    public function render()
    {
        return view('livewire.dashboard.funeral-schedules-widget',[
            'funeral_schedules' => $this->schedules,
        ]);
    }
}
