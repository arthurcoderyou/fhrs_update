<?php

namespace App\Livewire\Dashboard;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\FuneralSchedule;
use App\Models\ServiceSchedule;

class ServiceSchedulesCalendarWidget extends Component
{


    protected $listeners = [
        'serviceScheduleCreated' => '$refresh',
        'serviceScheduleUpdated' => '$refresh',
        'serviceScheduleDeleted' => '$refresh',  
        'dashboardUpdated' => '$refresh',
    ];

    public $events = [];

    public $date_range;


    public function getCalendarEvents()
    {
        // return FuneralSchedule::query()
        //     ->when($this->date_range, function ($query) {
        //         $dates = explode(' to ', $this->date_range);
        //         try {
        //             if (count($dates) === 2) {
        //                 $start = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
        //                 $end = Carbon::createFromFormat('m d Y', $dates[1])->endOfDay();
        //             } elseif (count($dates) === 1) {
        //                 $start = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
        //                 $end = Carbon::createFromFormat('m d Y', $dates[0])->endOfDay();
        //             } else {
        //                 return;
        //             }

        //             $query->whereBetween('date', [$start, $end]);

        //         } catch (\Exception $e) {
        //             $this->addError('date', 'The date format is invalid. Please use MM DD YYYY.');
        //             return;
        //         }
        //     })
        //     ->limit(100)
        //     ->get()->map(function ($schedule) {
        //     return [
        //         'title' => $schedule->name_of_person,
        //         // 'title' => "{$schedule->name_of_person} - Mass: {$schedule->mass_time}, Cemetery: {$schedule->burial_cemetery}, Location: {$schedule->burial_location}",
        //         'desc' => "{$schedule->name_of_person}\nMass: {$schedule->mass_time}\nCemetery: {$schedule->burial_cemetery}\nLocation: {$schedule->burial_location}",
        //         // 'full_description' => $schedule->name_of_person."- Cemetery: ".$schedule->burial_cemetery,

                
        //         'start' => $schedule->date->toDateString(), // assuming $schedule->date is a Carbon instance
        //         'url' => route('funeral_schedule.show', $schedule->id), // optional

        //         // 'start' => $schedule->date . 'T' . $schedule->mass_time, // combine date and time
        //         // 'extendedProps' => [
        //         //     'burial_cemetery' => $schedule->burial_cemetery,
        //         //     'burial_location' => $schedule->burial_location,
        //         // ],


        //     ];
        // });



        return ServiceSchedule::query()
            // ->when($this->search, callback: fn($query) =>
            //         $query->whereHas('user', fn($q) => 
            //                     $q->where('name', 'like', "%{$this->search}%")  
            //                         ->orWhere('email', 'like', "%{$this->search}%")
            //                 )
            //                 ->orWhereHas('creator', fn($q) => 
            //                     $q->where('name', 'like', "%{$this->search}%")
            //                         ->orWhere('email', 'like', "%{$this->search}%")
            //                 )
            //     )
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

    public function mount()
    {
        // Default: 1st to last day of the current month
        $start = Carbon::now()->startOfMonth()->format('m d Y');
        $end = Carbon::now()->endOfMonth()->format('m d Y');

        $this->date_range = "{$start} to {$end}";
    }


    public function render()
    {

        $calendarEvents = $this->getCalendarEvents();

        $this->dispatch('serviceCalendarEventsUpdated', events: $calendarEvents);


       


        return view('livewire.dashboard.service-schedules-calendar-widget',[
            'calendar_events' => $this->getCalendarEvents(),
        ]);
    }
}
