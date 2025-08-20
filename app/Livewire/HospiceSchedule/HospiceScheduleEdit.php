<?php

namespace App\Livewire\HospiceSchedule;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\HospiceSchedule;
use Illuminate\Support\Facades\Log;
use App\Events\HospiceScheduleUpdated;

class HospiceScheduleEdit extends Component
{

    public $name;
    public $start_date;
    public $end_date;
  
    public string $date_range = '';

    public int $hospice_schedule_id;
     

    public function mount(HospiceSchedule $hospice_schedule){
 

        $this->hospice_schedule_id = $hospice_schedule->id;
        $this->name = $hospice_schedule->name;
 

        $this->date_range = optional($hospice_schedule->start_date)->format('m d Y').' to '. optional($hospice_schedule->end_date)->format('m d Y');  

    }

    public function updated($fields)
    {
        // Always validate date_range first
        $this->validateOnly('date_range', [
            'date_range' => ['required'],
        ]);

        // Try parsing the date_range
        $dates = explode(' to ', $this->date_range);

        try {
            if (count($dates) === 2) {
                $start = Carbon::createFromFormat('m d Y', trim($dates[0]))->startOfDay();
                $end = Carbon::createFromFormat('m d Y', trim($dates[1]))->endOfDay();
            } elseif (count($dates) === 1) {
                $start = Carbon::createFromFormat('m d Y', trim($dates[0]))->startOfDay();
                $end = $start->copy()->endOfDay();
            } else {
                $this->addError('date_range', 'The date range format is invalid.');
                return;
            }

            // Populate start_date and end_date from date_range
            $this->start_date = $start->format('Y-m-d');
            $this->end_date = $end->format('Y-m-d');

        } catch (\Exception $e) {
            $this->addError('date_range', 'The date format is invalid. Please use MM DD YYYY.');
            return;
        }

        // Now validate other fields including derived dates
        $this->validateOnly($fields, [
            'name' => [
                'required',
                'string',
                'unique:hospice_schedules,name,'.$this->hospice_schedule_id,
            ],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ],[
            'name.unique' => 'Patient name is already on the list'
        ]);

        $this->resetErrorBag();
    }

        
 
 



    /**
     * Handle an incoming registration request.
     */
    public function save()
    {
 
        // Always validate date_range first
        $this->validate( [
            'name' => [
                'required',
                'string',
                'unique:hospice_schedules,name,'.$this->hospice_schedule_id,
            ],
            'date_range' => ['required'],
        ],[
             'name.unique' => 'Patient name is already on the list'
        ]);

        // Try parsing the date_range
        $dates = explode(' to ', $this->date_range);

        try {
            if (count($dates) === 2) {
                $start = Carbon::createFromFormat('m d Y', trim($dates[0]))->startOfDay();
                $end = Carbon::createFromFormat('m d Y', trim($dates[1]))->endOfDay();
            } elseif (count($dates) === 1) {
                $start = Carbon::createFromFormat('m d Y', trim($dates[0]))->startOfDay();
                $end = $start->copy()->endOfDay();
            } else {
                $this->addError('date_range', 'The date range format is invalid.');
                return;
            }

            // Populate start_date and end_date from date_range
            $this->start_date = $start->format('Y-m-d');
            $this->end_date = $end->format('Y-m-d');

        } catch (\Exception $e) {
            $this->addError('date_range', 'The date format is invalid. Please use MM DD YYYY.');
            return;
        }

        // Now validate other fields including derived dates
        $this->validate( [
             
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date'],
        ],[
             'name.unique' => 'Patient name is already on the list'
        ]);

        


        //save
        $hospice_schedule = HospiceSchedule::where('id',$this->hospice_schedule_id)->first();
        $hospice_schedule->name = $this->name;
        $hospice_schedule->start_date = $this->start_date;
        $hospice_schedule->end_date = $this->end_date; 
        $hospice_schedule->updated_by = auth()->user()->id;
        $hospice_schedule->updated_at = now();
        $hospice_schedule->save();
  
        
        try {
            event(new HospiceScheduleUpdated($hospice_schedule));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send HospiceScheduleUpdated event: ' . $e->getMessage(), [
                'hospice_schedule' => $hospice_schedule->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


        return redirect()->route('hospice_schedule.index');
    }


    public function render()
    {
        return view('livewire.hospice-schedule.hospice-schedule-edit')->layout('layouts.app');
    }
}
