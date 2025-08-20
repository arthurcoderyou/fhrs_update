<?php

namespace App\Livewire\FuneralSchedule;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\FuneralSchedule;
use App\Models\HospiceSchedule;
use App\Models\FuneralAttachments;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Events\FuneralScheduleCreated;
use App\Helpers\FuneralReminderHelper;
use Illuminate\Support\Facades\Storage;
use App\Events\PublicFuneralScheduleCreated;

class FuneralScheduleCreate extends Component
{
    public $name_of_person;
    public $date;

    public $mass_time;
    public $public_viewing_start;
    public $public_viewing_end;
    public $family_viewing_start;
    public $family_viewing_end;
    public $burial_cemetery;
    public $burial_location;
    public $hearse;
    public $funeral_director;
    public $co_funeral_director;
    public $folder;
    
    public array $familyArrivals = [
        ['time' => '', 'notes' => '']
    ];

    public array $flowers = [
        ['name' => '', 'notes' => '']
    ];

    public array $equipments = [
        ['name' => '', 'notes' => '']
    ];

    public array $familyPointOfContact = [
        ['phone' => '', 'notes' => '']
    ];

    public $attachments = []; // Attachments 


    public $hospice_schedule;
    public $hospice_schedule_id;

    public function mount(){
        $this->hospice_schedule_id = request()->get('hospice_schedule_id') ?? null;

        if(!empty($this->hospice_schedule_id)){
            $this->hospice_schedule = HospiceSchedule::find($this->hospice_schedule_id) ?? null;

            $this->name_of_person = $this->hospice_schedule->name ?? null;

            // check if there are already funeral schedule for the hospice, redirect ot that funeral schedule
            $funeral_schedule = $this->hospice_schedule->funeral_schedules->first();

            if(!empty($funeral_schedule)){
                $this->redirect(route('funeral_schedule.show',['funeral_schedule' => $funeral_schedule->id], absolute: false), navigate: true);
            }


        }

    }


    public function updated($fields){
        $this->validateOnly($fields,[
            'name_of_person' => [
                'required',
                'string', 
                'unique:funeral_schedules,name_of_person',
            ],

            'folder' => [
                'unique:funeral_schedules,folder',
            ],

            'date' => [
                'required',
            ],
            'mass_time' => [
                'required',  
            ],
            'public_viewing_start' => [
                'required',  
            ],
            'public_viewing_end' => [
                'required',  
            ],
            'family_viewing_start' => [
                'required',  
            ],
            'family_viewing_end' => [
                'required',  
            ],
            'burial_cemetery' => [
                'required',
                'string', 
            ],
            'burial_location' => [
                'required',
                'string', 
            ],
            'hearse' => [
                'required',
                'string', 
            ],
            'funeral_director' => [
                'required',
                'string', 
            ],
            'co_funeral_director' => [
                'required',
                'string', 
            ],
            // Add this for familyArrivals
            'familyArrivals' => 'required|array|min:1',
            'familyArrivals.*.time' => 'required|string',
            'familyArrivals.*.notes' => 'nullable|string',

            // Add this for flowers
            'flowers' => 'required|array|min:1',
            'flowers.*.name' => 'required|string',
            'flowers.*.notes' => 'nullable|string',

            // Add this for equipments
            'equipments' => 'required|array|min:1',
            'equipments.*.name' => 'required|string',
            'equipments.*.notes' => 'nullable|string',

            // Add this for familyPoin
            'familyPointOfContact' => 'required|array|min:1',
            'familyPointOfContact.*.phone' => 'required|string',
            'familyPointOfContact.*.notes' => 'nullable|string',



        ],[
            'name_of_person.unique' => 'The name of person has already been recorded on the funeral schedules. ',
            'familyArrivals.*.time.required' => 'Each family arrival must have a valid time.', 
        ]);


        // $this->updateFolder();


        try {
            $parsedDate = Carbon::createFromFormat('m d Y', $this->date)->format('Y-m-d');
        } catch (\Exception $e) {
            $this->addError('date', 'Invalid date format. Please use MM DD YYYY.');
            return;
        }

        try {
            $parsed_mass_time = Carbon::createFromFormat('g:i A', $this->mass_time)->format('H:i:s');
        } catch (\Exception $e) {
            $this->addError('mass_time', 'Invalid mass time format. Please use HH:MM AM/PM.');
            return;
        }

        try {
            $parsed_public_viewing_start = Carbon::createFromFormat('g:i A', $this->public_viewing_start);
            $parsed_public_viewing_end = Carbon::createFromFormat('g:i A', $this->public_viewing_end);

            if ($parsed_public_viewing_start->greaterThanOrEqualTo($parsed_public_viewing_end)) {
                $this->addError('public_viewing_start', 'Start time must be earlier than end time.');
                $this->addError('public_viewing_end', 'End time must be later than start time.');
                return;
            }

            $parsed_public_viewing_start = $parsed_public_viewing_start->format('H:i:s');
            $parsed_public_viewing_end = $parsed_public_viewing_end->format('H:i:s');
        } catch (\Exception $e) {
            $this->addError('public_viewing', 'Invalid public viewing time format. Please use HH:MM AM/PM.');
            return;
        }

        try {
            $parsed_family_viewing_start = Carbon::createFromFormat('g:i A', $this->family_viewing_start);
            $parsed_family_viewing_end = Carbon::createFromFormat('g:i A', $this->family_viewing_end);

            if ($parsed_family_viewing_start->greaterThanOrEqualTo($parsed_family_viewing_end)) {
                $this->addError('family_viewing_start', 'Start time must be earlier than end time.');
                $this->addError('family_viewing_end', 'End time must be later than start time.');
                return;
            }

            $parsed_family_viewing_start = $parsed_family_viewing_start->format('H:i:s');
            $parsed_family_viewing_end = $parsed_family_viewing_end->format('H:i:s');
        } catch (\Exception $e) {
            $this->addError('family_viewing', 'Invalid family viewing time format. Please use HH:MM AM/PM.');
            return;
        }



    

        $this->resetErrorBag();



    }


    public function updatedNameOfPerson($value)
    {
        $this->folder = Str::slug($value).'-'.now()->format('m-d-Y');
    }



    public function addFamilyArrival()
    {
        $this->familyArrivals[] = ['time' => '', 'notes' => ''];
    }

    public function removeFamilyArrival($index)
    {
        unset($this->familyArrivals[$index]);
        $this->familyArrivals = array_values($this->familyArrivals); // Reindex
    }

    public function addflower()
    {
        $this->flowers[] = ['name' => '', 'notes' => ''];
    }

    public function removeflower($index)
    {
        unset($this->flowers[$index]);
        $this->flowers = array_values($this->flowers); // Reindex
    }

    public function addEquipment()
    {
        $this->equipments[] = ['name' => '', 'notes' => ''];
    }

    public function removeEquipment($index)
    {
        unset($this->equipments[$index]);
        $this->equipments = array_values($this->equipments); // Reindex
    }

    public function addFamilyPointOfContact()
    {
        $this->familyPointOfContact[] = ['phone' => '', 'notes' => ''];
    }

    public function removeFamilyPointOfContact($index)
    {
        unset($this->familyPointOfContact[$index]);
        $this->familyPointOfContact = array_values($this->familyPointOfContact); // Reindex
    }



    



    /**
     * Handle an incoming registration request.
     */
    public function save()
    {

        //  // Check FTP connection before processing
        // try {
        //     Storage::disk('ftp')->exists('/'); // Basic check
            

        // } catch (\Exception $e) {
        //     // Handle failed connection
        //     dd("FTP connection failed: " . $e->getMessage());
        //     // logger()->error("FTP connection failed: " . $e->getMessage());
        //     // return; // Exit or show error as needed
        // }

        // dd("No problem");


        
 
        $this->validate([
            'name_of_person' => [
                'required',
                'string', 
                'unique:funeral_schedules,name_of_person',
            ],
             'folder' => [
                'unique:funeral_schedules,folder',
            ],
            'date' => [
                'required',
            ],
             'mass_time' => [
                'required',  
            ],
            'public_viewing_start' => [
                'required',  
            ],
            'public_viewing_end' => [
                'required',  
            ],
            'family_viewing_start' => [
                'required',  
            ],
            'family_viewing_end' => [
                'required',  
            ],
            'burial_cemetery' => [
                'required',
                'string', 
            ],
            'burial_location' => [
                'required',
                'string', 
            ],
            'hearse' => [
                'required',
                'string', 
            ],
            'funeral_director' => [
                'required',
                'string', 
            ],
            'co_funeral_director' => [
                'required',
                'string', 
            ],
            // Add this for familyArrivals
            'familyArrivals' => 'required|array|min:1',
            'familyArrivals.*.time' => 'required|string',
            'familyArrivals.*.notes' => 'nullable|string',

            // Add this for flowers
            'flowers' => 'required|array|min:1',
            'flowers.*.name' => 'required|string',
            'flowers.*.notes' => 'nullable|string',

            // Add this for equipments
            'equipments' => 'required|array|min:1',
            'equipments.*.name' => 'required|string',
            'equipments.*.notes' => 'nullable|string',

            // Add this for familyPoin
            'familyPointOfContact' => 'required|array|min:1',
            'familyPointOfContact.*.phone' => 'required|string',
            'familyPointOfContact.*.notes' => 'nullable|string',


        ],[
            'name_of_person.unique' => 'The name of person has already been recorded on the funeral schedules. ',
            'familyArrivals.*.time.required' => 'Each family arrival must have a valid time.',
        ]);


        try {
            $parsedDate = Carbon::createFromFormat('m d Y', $this->date)->format('Y-m-d');
        } catch (\Exception $e) {
            $this->addError('date', 'Invalid date format. Please use MM DD YYYY.');
            return;
        }

        try {
            $parsed_mass_time = Carbon::createFromFormat('g:i A', $this->mass_time)->format('H:i:s');
        } catch (\Exception $e) {
            $this->addError('mass_time', 'Invalid mass time format. Please use HH:MM AM/PM.');
            return;
        }

        try {
            $parsed_public_viewing_start = Carbon::createFromFormat('g:i A', $this->public_viewing_start);
            $parsed_public_viewing_end = Carbon::createFromFormat('g:i A', $this->public_viewing_end);

            if ($parsed_public_viewing_start->greaterThanOrEqualTo($parsed_public_viewing_end)) {
                $this->addError('public_viewing_start', 'Start time must be earlier than end time.');
                $this->addError('public_viewing_end', 'End time must be later than start time.');
                return;
            }

            $parsed_public_viewing_start = $parsed_public_viewing_start->format('H:i:s');
            $parsed_public_viewing_end = $parsed_public_viewing_end->format('H:i:s');
        } catch (\Exception $e) {
            $this->addError('public_viewing', 'Invalid public viewing time format. Please use HH:MM AM/PM.');
            return;
        }

        try {
            $parsed_family_viewing_start = Carbon::createFromFormat('g:i A', $this->family_viewing_start);
            $parsed_family_viewing_end = Carbon::createFromFormat('g:i A', $this->family_viewing_end);

            if ($parsed_family_viewing_start->greaterThanOrEqualTo($parsed_family_viewing_end)) {
                $this->addError('family_viewing_start', 'Start time must be earlier than end time.');
                $this->addError('family_viewing_end', 'End time must be later than start time.');
                return;
            }

            $parsed_family_viewing_start = $parsed_family_viewing_start->format('H:i:s');
            $parsed_family_viewing_end = $parsed_family_viewing_end->format('H:i:s');
        } catch (\Exception $e) {
            $this->addError('family_viewing', 'Invalid family viewing time format. Please use HH:MM AM/PM.');
            return;
        }




        //save
        $funeral_schedule = FuneralSchedule::create([
            'name_of_person' => $this->name_of_person,
            'burial_cemetery' => $this->burial_cemetery,
            'burial_location' => $this->burial_location,
            'hearse' => $this->hearse,
            'funeral_director' => $this->funeral_director,
            'co_funeral_director' => $this->co_funeral_director,

            'date' => $parsedDate,
            'mass_time'  => $parsed_mass_time,
            'public_viewing_start' => $parsed_public_viewing_start,
            'public_viewing_end' => $parsed_public_viewing_end,
            'family_viewing_start' => $parsed_family_viewing_start,
            'family_viewing_end' => $parsed_family_viewing_end,
            
            'hospice_schedule_id' => $this->hospice_schedule_id,
            'folder' => $this->folder,

            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);


        foreach ($this->familyArrivals as $arrival) {

            if(!empty($arrival['time']) && !empty($arrival['notes'])){
                $funeral_schedule->familyArrivals()->create([
                    'time' => $arrival['time'],
                    'notes' => $arrival['notes'] ?? null,
                ]);
            }
           
        }

        foreach ($this->flowers as $flower) {

            if(!empty($flower['name']) && !empty($flower['notes'])){
                $funeral_schedule->flowers()->create([
                    'name' => $flower['name'],
                    'notes' => $flower['notes'] ?? null,
                ]);
            }
           
        }

        foreach ($this->equipments as $equipment) {

            if(!empty($equipment['name']) && !empty($equipment['notes'])){
                $funeral_schedule->equipments()->create([
                    'name' => $equipment['name'],
                    'notes' => $equipment['notes'] ?? null,
                ]);
            }
           
        }


        foreach ($this->familyPointOfContact as $contact) {

            if(!empty($contact['phone']) && !empty($contact['notes'])){
                $funeral_schedule->familyPointOfContact()->create([
                    'phone' => $contact['phone'],
                    'notes' => $contact['notes'] ?? null,
                ]);
            }
           
        }

        /*
        if (!empty($this->attachments)) {

             

            foreach ($this->attachments as $file) {
        
                // // Store the original file name
                // $originalFileName = $file->getClientOriginalName(); 

                // // Generate a unique file name
                // $fileName = Carbon::now()->timestamp . '-' . $project->id . '-' . $originalFileName . '.' . $file->getClientOriginalExtension();

                // // Generate a unique file name
                // $fileName = Carbon::now()->timestamp . '-' . $review->id . '-' . uniqid() . '.' . $file['extension'];



                $originalFileName = $file['name'] ?? 'attachment';
                $extension = $file['extension'] ?? pathinfo($originalFileName, PATHINFO_EXTENSION);

                $fileName = Carbon::now()->timestamp . '-' . $funeral_schedule->id . '-' . pathinfo($originalFileName, PATHINFO_FILENAME) . '.' . $extension;


        
                // Move the file manually from temporary storage
                $sourcePath = $file['path'];
                $destinationPath = storage_path("app/public/uploads/funeral_attachments/{$fileName}");
        
                // Ensure the directory exists
                if (!file_exists(dirname($destinationPath))) {
                    mkdir(dirname($destinationPath), 0777, true);
                }
        
                // Move the file to the destination
                if (file_exists($sourcePath)) {
                    rename($sourcePath, $destinationPath);
                } else {
                    // Log or handle the error (file might not exist at the temporary path)
                    continue;
                }
        
                // Save to the database
                FuneralAttachments::create([
                    'attachment' => $fileName,
                    'funeral_schedule_id' => $funeral_schedule->id, 
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
            }
        }
        */
 

        if (!empty($this->attachments)) {

            // Check FTP connection before processing
            try {
                Storage::disk('ftp')->exists('/'); // Basic check
            } catch (\Exception $e) {
                // Handle failed connection
                logger()->error("FTP connection failed: " . $e->getMessage());
                return; // Exit or show error as needed
            }

            foreach ($this->attachments as $file) {

                $originalFileName = $file['name'] ?? 'attachment';
                $extension = $file['extension'] ?? pathinfo($originalFileName, PATHINFO_EXTENSION);
                $baseName = pathinfo($originalFileName, PATHINFO_FILENAME);

                $fileName = Carbon::now()->timestamp . '-' . $funeral_schedule->id . '-' . $baseName . '.' . $extension;

                $sourcePath = $file['path'];

                if (!file_exists($sourcePath)) {
                    logger()->warning("Source file does not exist: $sourcePath");
                    continue;
                }

                // Read the file content
                $fileContents = file_get_contents($sourcePath);

                // Destination path on FTP
                $ftpPath = "uploads/funeral_attachments/{$funeral_schedule->folder}/{$fileName}";

                // Create directory if not exists (Flysystem handles this automatically when uploading a file)
                $uploadSuccess = Storage::disk('ftp')->put($ftpPath, $fileContents);

                if (!$uploadSuccess) {
                    logger()->error("Failed to upload file to FTP: $ftpPath");
                    continue;
                }

                // Delete local temp file
                unlink($sourcePath);

                // Save record to DB
                FuneralAttachments::create([
                    'attachment' => $fileName,
                    'funeral_schedule_id' => $funeral_schedule->id,
                    'created_by' => Auth::id(),
                    'updated_by' => Auth::id(),
                ]);
            }
        }



        // check if the date of the funeral is within the date range and if yes, send the notification email
        $today = now()->startOfDay();
        $inThreeDays = now()->copy()->addDays(3)->startOfDay();

        if ($funeral_schedule->date->between($today, $inThreeDays)) {
            FuneralReminderHelper::sendReminderToAllUsers($funeral_schedule,'funeral create');
        }
 

         

        /**Private Channel */
        try {
            event(new FuneralScheduleCreated($funeral_schedule));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send FuneralScheduleCreated event: ' . $e->getMessage(), [
                'funeral_schedule' => $funeral_schedule->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        /**Public Channel */ 
        try {
            event(new PublicFuneralScheduleCreated($funeral_schedule));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicFuneralScheduleCreated event: ' . $e->getMessage(), [
                'funeral_schedule' => $funeral_schedule->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        
        return redirect()->route('funeral_schedule.index');
    }


    public function render()
    {
        return view('livewire.funeral-schedule.funeral-schedule-create')
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
