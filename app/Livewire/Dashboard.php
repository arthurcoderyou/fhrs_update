<?php

namespace App\Livewire;

use App\Models\Setting;
use Livewire\Component;

class Dashboard extends Component
{

    protected $listeners = [
        'funeralScheduleCreated' => '$refresh',
        'funeralScheduleUpdated' => '$refresh',
        'funeralScheduleDeleted' => '$refresh',  
        'settingCreated' => 'refresh',
        'settingUpdated' => 'refresh',
        'settingDeleted' => 'refresh',  
    ];
    public function getShowDashboardTodaySchedulesProperty(){
        return Setting::where('key','show_dashboard_today_schedules')->first()->value ;

    }

    public function getShowDashboardTableProperty(){
        return Setting::where('key','show_dashboard_funeral_schedule_table')->first()->value ;

    }

    public function getShowDashboardCalendarProperty(){
        return Setting::where('key','show_dashboard_calendar')->first()->value ;

    }

    public function getShowDashboardServiceCalendarProperty(){
        return Setting::where('key','show_dashboard_service_calendar')->first()->value ;

    }



    public function render()
    {
        return view('livewire.dashboard',[
            'show_dashboard_today_schedules' => $this->showDashboardTodaySchedules,
            'show_dashboard_calendar' => $this->showDashboardCalendar,
            'show_dashboard_service_calendar' => $this->showDashboardServiceCalendar,
            'show_dashboard_table' => $this->showDashboardTable,
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
    }





}
