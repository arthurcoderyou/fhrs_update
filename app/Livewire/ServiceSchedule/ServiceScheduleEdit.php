<?php

namespace App\Livewire\ServiceSchedule;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use App\Models\ServiceSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Events\ServiceScheduleUpdated;
use App\Events\PublicServiceScheduleUpdated;

class ServiceScheduleEdit extends Component
{

    public $user_id;
    public $is_recurring = true;
    public $recurring_days = [];
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
 
 
    public string $date_range = '';

    public $all_days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

    public $service_schedule_id;

    public $user;


    public function mount(ServiceSchedule $service_schedule){

        $this->service_schedule_id = $service_schedule->id;
        $this->loadServiceSchedule();

    }

    public function loadServiceSchedule(){

        $service_schedule = ServiceSchedule::findOrFail($this->service_schedule_id);
        $this->user = $service_schedule->user->name;

        $this->user_id = $service_schedule->user_id;
        $this->is_recurring = $service_schedule->is_recurring;
        // $this->recurring_days = json_decode($service_schedule->recurring_days, true);
        // $this->start_date = $service_schedule->start_date;
        // $this->end_date = $service_schedule->end_date;
        $this->start_time = optional($service_schedule->start_time)->format('h:i A');
        $this->end_time = optional($service_schedule->end_time)->format('h:i A');
    
        $this->date_range = optional($service_schedule->schedule_date)->format('m d Y');

        // if(!empty($service_schedule->end_date)){
        //     $this->date_range .= " to ".optional($service_schedule->end_date)->format('m d Y');
        // }

 

        // $this->date = optional($funeral_schedule->date)->format('m d Y'); 
        // $this->mass_time = optional($funeral_schedule->mass_time)->format('h:i A');
        // $this->public_viewing_start = optional($funeral_schedule->public_viewing_start)->format('h:i A');
        // $this->public_viewing_end = optional($funeral_schedule->public_viewing_end)->format('h:i A');
        // $this->family_viewing_start = optional($funeral_schedule->family_viewing_start)->format('h:i A');
        // $this->family_viewing_end = optional($funeral_schedule->family_viewing_end)->format('h:i A');



    }

    // public function getUsersProperty(){

    //     return User::orderBy('name','ASC')->pluck('name','id')->toArray();

    // }


     public function updated($fields){
        $this->validateOnly($fields,[  
            'start_time' => 'required',
            'end_time' => 'required', 
        ],[ 
        ]);

 

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

    public function save(){

        
        $this->validate( [  
            'start_time' => 'required',
            'end_time' => 'required', 
        ],[ 
        ]);
        

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

        
       

        $service_schedule = ServiceSchedule::find($this->service_schedule_id); 
 

        $startTimestamp = Carbon::parse($service_schedule->schedule_date->format('Y-m-d') . ' ' . $this->start_time);
        $endTimestamp = Carbon::parse($service_schedule->schedule_date->format('Y-m-d') . ' ' . $this->end_time);

        $service_schedule->start_time = $startTimestamp;
        $service_schedule->end_time = $endTimestamp;

        $service_schedule->created_by = Auth::id();
        $service_schedule->save();



        $service_schedule = ServiceSchedule::where('id',$service_schedule->id)->first();
        try {
           event(new ServiceScheduleUpdated($service_schedule));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send ServiceScheduleUpdated event: ' . $e->getMessage(), [
                'service_schedule' => $service_schedule->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        try {
           event(new PublicServiceScheduleUpdated($service_schedule));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicServiceScheduleUpdated event: ' . $e->getMessage(), [
                'service_schedule' => $service_schedule->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


        return redirect()->route('service_schedule.index');


    }

    

    public function render()
    {
        return view('livewire.service-schedule.service-schedule-edit',[
            // 'users' => $this->users,
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
