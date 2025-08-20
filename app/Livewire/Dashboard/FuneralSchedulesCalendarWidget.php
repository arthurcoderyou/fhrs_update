<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\FuneralSchedule;

class FuneralSchedulesCalendarWidget extends Component
{

    protected $listeners = [
        'funeralScheduleCreated' => '$refresh',
        'funeralScheduleUpdated' => '$refresh',
        'funeralScheduleDeleted' => '$refresh',  
        'dashboardUpdated' => '$refresh',
    ];

    public $events = [];

    public $date_range;


    public function getCalendarEvents()
    {
        return FuneralSchedule::query()
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
            ->limit(100)
            ->get()->map(function ($schedule) {
            return [
                'title' => $schedule->name_of_person,
                // 'title' => "{$schedule->name_of_person} - Mass: {$schedule->mass_time}, Cemetery: {$schedule->burial_cemetery}, Location: {$schedule->burial_location}",
                'desc' => "{$schedule->name_of_person}\nMass: {$schedule->mass_time}\nCemetery: {$schedule->burial_cemetery}\nLocation: {$schedule->burial_location}",
                // 'full_description' => $schedule->name_of_person."- Cemetery: ".$schedule->burial_cemetery,

                
                'start' => $schedule->date->toDateString(), // assuming $schedule->date is a Carbon instance
                'url' => route('funeral_schedule.show', $schedule->id), // optional

                // 'start' => $schedule->date . 'T' . $schedule->mass_time, // combine date and time
                // 'extendedProps' => [
                //     'burial_cemetery' => $schedule->burial_cemetery,
                //     'burial_location' => $schedule->burial_location,
                // ],


            ];
        });
    }

    public function mount()
    {
        // Default: 1st to last day of the current month
        $start = Carbon::now()->startOfMonth()->format('m d Y');
        $end = Carbon::now()->endOfMonth()->format('m d Y');

        $this->date_range = "{$start} to {$end}";
    }

    public function render()
    {

        // $this->events = FuneralSchedule::all()->map(function ($schedule) {
        //     return [
        //         // 'title' => $schedule->name_of_person,
        //         'title' => "{$schedule->name_of_person} - Mass: {$schedule->mass_time}, Cemetery: {$schedule->burial_cemetery}, Location: {$schedule->burial_location}",
        
        //         'start' => $schedule->date->toDateString(),
        //         'id'    => $schedule->id,
        //     ];
        // })->toArray();


        $calendarEvents = $this->getCalendarEvents();

        $this->dispatch('calendarEventsUpdated', events: $calendarEvents);


        return view('livewire.dashboard.funeral-schedules-calendar-widget',[
            // 'events' => $this->events,
            'calendar_events' => $this->getCalendarEvents(),
        ]);
    }
}
