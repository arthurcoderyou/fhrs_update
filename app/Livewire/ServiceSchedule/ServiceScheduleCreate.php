<?php

namespace App\Livewire\ServiceSchedule;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\ServiceSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Events\ServiceScheduleCreated;
use App\Events\PublicServiceScheduleCreated;

class ServiceScheduleCreate extends Component
{
 
    public $user_id;
    public $is_recurring = true;
    public $recurring_days = [];
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
 
 
    public string $date_range = '';

    public $all_days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

    public function mount( )
    {
        // if ($schedule_id) {
        //     $schedule = WorkerSchedule::findOrFail($schedule_id);
        //     $this->schedule_id = $schedule->id;
        //     $this->worker_id = $schedule->worker_id;
        //     $this->is_recurring = $schedule->is_recurring;
        //     $this->recurring_days = $schedule->recurring_days ?? [];
        //     $this->start_date = $schedule->start_date->format('Y-m-d');
        //     $this->end_date = optional($schedule->end_date)->format('Y-m-d');
        //     $this->start_time = $schedule->start_time;
        //     $this->end_time = $schedule->end_time;
        // }
    }


    public function updated($fields){
        $this->validateOnly($fields,[
            'user_id' => 'required|exists:users,id',
            // 'is_recurring' => 'boolean',
            'recurring_days' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',

            'date_range' => 'required',


        ],[ 
        ]);


        // $this->updateFolder();

 

        try {
            // Validate and parse the date range
            $dates = explode(' to ', $this->date_range);

            if (count($dates) === 2) {
                $startDate = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
                $endDate = Carbon::createFromFormat('m d Y', $dates[1])->endOfDay();
            } elseif (count($dates) === 1) {
                $startDate = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
                $endDate = Carbon::createFromFormat('m d Y', $dates[0])->endOfDay();
            } else {
                $this->addError('date_range', 'Invalid date range format. Please use MM DD YYYY or MM DD YYYY to MM DD YYYY.');
                return;
            }
        } catch (\Exception $e) {
            $this->addError('date_range', 'The date format is invalid. Please use MM DD YYYY.');
            return;
        }

        try {
            $parsed_start_time = Carbon::createFromFormat('g:i A', $this->start_time);
            $parsed_end_time = Carbon::createFromFormat('g:i A', $this->end_time);

            if ($parsed_start_time->greaterThanOrEqualTo($parsed_end_time)) {
                $this->addError('start_time', 'Start time must be earlier than end time.');
                $this->addError('end_time', 'End time must be later than start time.');
                return;
            }

            $parsed_start_time = $parsed_start_time->format('H:i:s');
            $parsed_end_time = $parsed_end_time->format('H:i:s');
        } catch (\Exception $e) {
            $this->addError('family_viewing', 'Invalid family viewing time format. Please use HH:MM AM/PM.');
            return;
        }



    

        $this->resetErrorBag();



    }



    public function getUsersProperty()
    {
        $query = User::query();

        // Exclude users with 'Global Administrator' role if current user doesn't have that role
        if (!auth()->user()->hasRole('Global Administrator')) {
            $query->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'Global Administrator');
            });
        }

        return $query->orderBy('name', 'ASC')->pluck('name', 'id')->toArray();
    }





    public function save()
    {

        //  dd($this->all());
        try {
            // Validate and parse the date range
            $dates = explode(' to ', $this->date_range);

            if (count($dates) === 2) {
                $this->start_date = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
                $this->end_date = Carbon::createFromFormat('m d Y', $dates[1])->endOfDay();
            } elseif (count($dates) === 1) {
                $this->start_date = Carbon::createFromFormat('m d Y', $dates[0])->startOfDay();
                $this->end_date = Carbon::createFromFormat('m d Y', $dates[0])->endOfDay();
            } else {
                $this->addError('date_range', 'Invalid date range format. Please use MM DD YYYY or MM DD YYYY to MM DD YYYY.');
                return;
            }
        } catch (\Exception $e) {
            // dd("Something went wrong");
            $this->addError('date_range', 'The date format is invalid. Please use MM DD YYYY.');
            return;
        }

        try {
            $parsed_start_time = Carbon::createFromFormat('g:i A', $this->start_time);
            $parsed_end_time = Carbon::createFromFormat('g:i A', $this->end_time);

            if ($parsed_start_time->greaterThanOrEqualTo($parsed_end_time)) {
                $this->addError('start_time', 'Start time must be earlier than end time.');
                $this->addError('end_time', 'End time must be later than start time.');
                return;
            }

            //convert into database entries
            $this->start_time = $parsed_start_time->format('H:i:s');
            $this->end_time = $parsed_end_time->format('H:i:s');
        } catch (\Exception $e) {
            $this->addError('start_time', 'Invalid family viewing time format. Please use HH:MM AM/PM.');
            return;
        }



        $this->validate([
            'user_id' => 'required|exists:users,id',
            // 'is_recurring' => 'boolean',
            'recurring_days' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',

            'date_range' => 'required',

        ]);

       
         

        // dd("All Goods");

        // $service_schedule = new ServiceSchedule();
        // $service_schedule->user_id = $this->user_id; 
        // $service_schedule->is_recurring = $this->is_recurring;
        // $service_schedule->recurring_days = !empty($this->recurring_days) ? json_encode($this->recurring_days) : null; 
        // $service_schedule->start_date = $this->start_date ?? null; 
        // $service_schedule->end_date = $this->end_date ?? null ;
        // $service_schedule->start_time = $parsed_start_time;
        // $service_schedule->end_time = $parsed_end_time;
        // $service_schedule->created_by = Auth::user()->id;
        // $service_schedule->save();  
        
        $recurringDays = $this->recurring_days ?? []; // e.g., ['Monday', 'Wednesday']
         
        $start = Carbon::parse($this->start_date);
        $end = Carbon::parse($this->end_date);

        $current = $start->copy();

        // dd($current->format('l'));
        while ($current->lte($end)) {
            // Check if this day matches one of the recurring days

            // dd("on the loop");
            // dd(in_array($current->format('l'), $recurringDays));

            if (in_array($current->format('l'), $recurringDays)) {

                // dd("true");
                // delete previuos service schedule with the same user_id and schedule_date
                $current_service_schedule = ServiceSchedule::where('user_id',$this->user_id)->whereDate('schedule_date',$current)->first();
                if(!empty($current_service_schedule)){
                    $current_service_schedule->delete();
                }
                


                $service_schedule = new ServiceSchedule();
                $service_schedule->user_id = $this->user_id;
                $service_schedule->is_recurring = $this->is_recurring;
                $service_schedule->recurring_days = json_encode($recurringDays); // optional to save again
                $service_schedule->schedule_date = $current->format('Y-m-d'); // save specific day
                // $service_schedule->start_time = $this->start_time;
                // $service_schedule->end_time = $this->end_time;

                $startTimestamp = Carbon::parse($current->format('Y-m-d') . ' ' . $this->start_time);
                $endTimestamp = Carbon::parse($current->format('Y-m-d') . ' ' . $this->end_time);

                $service_schedule->start_time = $startTimestamp;
                $service_schedule->end_time = $endTimestamp;

                $service_schedule->created_by = Auth::id();
                $service_schedule->save();


                // dd("Saved");
            }

            $current->addDay(); // move to next date
        }

        // Optionally confirm after the loop
        // dd("All matching schedules saved.");


 

        try {
           event(new ServiceScheduleCreated($service_schedule));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send ServiceScheduleCreated event: ' . $e->getMessage(), [
                'service_schedule' => $service_schedule->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        try {
           event(new PublicServiceScheduleCreated($service_schedule));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicServiceScheduleCreated event: ' . $e->getMessage(), [
                'service_schedule' => $service_schedule->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


        return redirect()->route('service_schedule.index');
    }


    public function render()
    {
        return view('livewire.service-schedule.service-schedule-create',[
            'users' => $this->users,
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
