<?php

namespace App\Livewire\FuneralSchedule;

use App\Events\PublicFuneralScheduleUpdated;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\FuneralSchedule;
use App\Models\FuneralAttachments;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Events\FuneralScheduleUpdated;
use App\Helpers\FuneralReminderHelper;
use Illuminate\Support\Facades\Storage;

class FuneralScheduleEdit extends Component
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

    public $original_folder;
 
    public array $familyArrivals = [];
    public array $flowers = [];

    public array $equipments = [];

    public array $familyPointOfContact = [ ];


    public $funeral_schedule_id;

    public $hospice_schedule;

    public array $existingFiles = [];   // existing attachment files for the funeral schedule

    public array $deletedAttachmentIds = [];    // deleted attachments ids for the funeral schedule

    public $attachments = []; // New Attachments 

    public function mount(FuneralSchedule $funeral_schedule){
 

        $this->funeral_schedule_id = $funeral_schedule->id;
        $this->name_of_person = $funeral_schedule->name_of_person;

        $this->burial_cemetery = $funeral_schedule->burial_cemetery;
        $this->burial_location = $funeral_schedule->burial_location;
        $this->hearse = $funeral_schedule->hearse;
        $this->funeral_director = $funeral_schedule->funeral_director;
        $this->co_funeral_director = $funeral_schedule->co_funeral_director;
        $this->folder = $funeral_schedule->folder ?? Str::slug($funeral_schedule->name_of_person).'-'.now()->format('m-d-Y');;

        $this->original_folder = $funeral_schedule->folder;


        $this->date = optional($funeral_schedule->date)->format('m d Y'); 
        $this->mass_time = optional($funeral_schedule->mass_time)->format('h:i A');
        $this->public_viewing_start = optional($funeral_schedule->public_viewing_start)->format('h:i A');
        $this->public_viewing_end = optional($funeral_schedule->public_viewing_end)->format('h:i A');
        $this->family_viewing_start = optional($funeral_schedule->family_viewing_start)->format('h:i A');
        $this->family_viewing_end = optional($funeral_schedule->family_viewing_end)->format('h:i A');

        // 👇 Load existing arrivals
        $this->familyArrivals = $funeral_schedule->familyArrivals->map(function ($arrival) {
            return [
                'time' =>optional($arrival->time)->format('H:i'), // 💡 key part,
                'notes' => $arrival->notes,
            ];
        })->toArray();

        // 👇 Load existing flowers
        $this->flowers = $funeral_schedule->flowers->map(function ($flower) {
            return [
                'name' => $flower->name,
                'notes' => $flower->notes,
            ];
        })->toArray();

        // 👇 Load existing equipments
        $this->equipments = $funeral_schedule->equipments->map(function ($equipment) {
            return [
                'name' => $equipment->name,
                'notes' => $equipment->notes,
            ];
        })->toArray();

        // 👇 Load existing family point of contacts 
        $this->familyPointOfContact = $funeral_schedule->familyPointOfContact->map(function ($contact) {
            return [
                'phone' => $contact->phone,
                'notes' => $contact->notes,
            ];
        })->toArray();


        $this->hospice_schedule = $funeral_schedule->hospice_schedule ?? null;

        $this->existingFiles = $this->getExistingFilesProperty();


    }
    public function updated($fields){
        $this->validateOnly($fields,[
            'name_of_person' => [
                'required',
                'string', 
                'unique:funeral_schedules,name_of_person,'.$this->funeral_schedule_id,
            ],
            'folder' => [
                'unique:funeral_schedules,folder,'.$this->funeral_schedule_id,
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



    public function getExistingFilesProperty()
    {

        $funeral_schedule = FuneralSchedule::find($this->funeral_schedule_id);


        if (empty($funeral_schedule->attachments) || $funeral_schedule->attachments->isEmpty()) {
            return [];
        }

        return $funeral_schedule->attachments
            ->sortByDesc('created_at')
            ->groupBy(function ($document) {
                return $document->created_at->format('M d, Y h:i A');
            })
            ->toArray();
    }


    public function removeAttachment($timestampKey, $attachmentId)
    {
        if (!isset($this->existingFiles[$timestampKey])) {
            return;
        }

        $this->existingFiles[$timestampKey] = array_filter(
            $this->existingFiles[$timestampKey],
            fn($attachment) => $attachment['id'] !== $attachmentId
        );

        

        // If no attachments left under that timestamp, remove the key entirely
        if (empty($this->existingFiles[$timestampKey])) {
            unset($this->existingFiles[$timestampKey]);
        }

        $this->deletedAttachmentIds[] = $attachmentId;    // add to the ids of attachments to be deleted after the save button 

    }


    /**
     * Handle an incoming registration request.
     */
    public function save()
    {

        // dd($this->deletedAttachmentIds);

        $this->validate([
            'name_of_person' => [
                'required',
                'string', 
                'unique:funeral_schedules,name_of_person,'.$this->funeral_schedule_id,
            ],
            'folder' => [
                'unique:funeral_schedules,folder,'.$this->funeral_schedule_id,
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
        $funeral_schedule = FuneralSchedule::where('id',$this->funeral_schedule_id)->first(); 
        $funeral_schedule->name_of_person = $this->name_of_person;
        $funeral_schedule->burial_cemetery = $this->burial_cemetery;
        $funeral_schedule->burial_location = $this->burial_location;
        $funeral_schedule->hearse = $this->hearse;
        $funeral_schedule->funeral_director = $this->funeral_director;
        $funeral_schedule->co_funeral_director = $this->co_funeral_director;
        $funeral_schedule->folder = $this->folder;

        $funeral_schedule->date = $parsedDate; 
        $funeral_schedule->mass_time  =  $parsed_mass_time;
        $funeral_schedule->public_viewing_start = $parsed_public_viewing_start;
        $funeral_schedule->public_viewing_end = $parsed_public_viewing_end;
        $funeral_schedule->family_viewing_start = $parsed_family_viewing_start;
        $funeral_schedule->family_viewing_end = $parsed_family_viewing_end;
            
 
        $funeral_schedule->updated_by = auth()->user()->id; 
        $funeral_schedule->updated_at = now(); 
        $funeral_schedule->save();



        // Remove previous records to avoid duplication
        $funeral_schedule->familyArrivals()->delete();

        // Re-insert new ones
        foreach ($this->familyArrivals as $arrival) {
            if (!empty($arrival['time'])) {
                $funeral_schedule->familyArrivals()->create([
                    'time' => $arrival['time'],
                    'notes' => $arrival['notes'] ?? null,
                ]);
            }
        }


        // Remove previous records to avoid duplication
        $funeral_schedule->flowers()->delete();

        // Re-insert new ones
        foreach ($this->flowers as $flower) {

            if(!empty($flower['name']) && !empty($flower['notes'])){
                $funeral_schedule->flowers()->create([
                    'name' => $flower['name'],
                    'notes' => $flower['notes'] ?? null,
                ]);
            }
           
        }

        // Remove previous records to avoid duplication6
        $funeral_schedule->equipments()->delete();

        foreach ($this->equipments as $equipment) {

            if(!empty($equipment['name']) && !empty($equipment['notes'])){
                $funeral_schedule->equipments()->create([
                    'name' => $equipment['name'],
                    'notes' => $equipment['notes'] ?? null,
                ]);
            }
           
        }


        // Remove previous records to avoid duplication6
        $funeral_schedule->familyPointOfContact()->delete();

        foreach ($this->familyPointOfContact as $contact) {

            if(!empty($contact['phone']) && !empty($contact['notes'])){
                $funeral_schedule->familyPointOfContact()->create([
                    'phone' => $contact['phone'],
                    'notes' => $contact['notes'] ?? null,
                ]);
            }
           
        }

        // delete attachments that are on 
        // deleteAtta
        // $deletedAttachmentIds

        if(!empty($this->deletedAttachmentIds)){
            foreach($this->deletedAttachmentIds as $key => $id){

                $attachment = FuneralAttachments::find($id);

                if (!$attachment) {
                    return; // Handle as needed (e.g. show error or skip)
                }

                // File path relative to 'public' disk
                $filePath = "uploads/funeral_attachments/{$attachment->funeral_schedule->folder}/{$attachment->attachment}";

                // Delete the file from storage
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }

                // Delete the DB record
                $attachment->delete();
                    

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
        }*/

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



        // check if the folder is different and if the folders are different , move the files 
        if ( !empty($this->original_folder) && ($this->original_folder !== $this->folder)) {
            $ftp = Storage::disk('ftp');

            $oldFolderPath = "uploads/funeral_attachments/{$this->original_folder}";
            $newFolderPath = "uploads/funeral_attachments/{$this->folder}";

            // Check if old folder exists
            if ($ftp->exists($oldFolderPath)) {

                // Get all files in the old folder
                $files = $ftp->files($oldFolderPath);

                // Make sure the new folder exists
                if (!$ftp->exists($newFolderPath)) {
                    $ftp->makeDirectory($newFolderPath);
                }

                // Move files from old to new
                foreach ($files as $filePath) {
                    $fileName = basename($filePath);
                    $newPath = $newFolderPath . '/' . $fileName;

                    $fileContent = $ftp->get($filePath);
                    $ftp->put($newPath, $fileContent);
                    $ftp->delete($filePath); // Optional: delete old file
                }

                // Delete the old folder after moving files
                $ftp->deleteDirectory($oldFolderPath);


                logger()->info("Moved files from $oldFolderPath to $newFolderPath");
            } else {
                logger()->warning("Original FTP folder does not exist: $oldFolderPath");
            }
        }



        // check if the date of the funeral is within the date range and if yes, send the notification email
        $today = now()->startOfDay();
        $inThreeDays = now()->copy()->addDays(3)->startOfDay();

        if ($funeral_schedule->date->between($today, $inThreeDays)) {
            FuneralReminderHelper::sendReminderToAllUsers($funeral_schedule,'funeral update');
        }

 

        try {
            event(new FuneralScheduleUpdated($funeral_schedule));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send FuneralScheduleUpdated event: ' . $e->getMessage(), [
                'funeral_schedule' => $funeral_schedule->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        try {
            event(new PublicFuneralScheduleUpdated($funeral_schedule));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicFuneralScheduleUpdated event: ' . $e->getMessage(), [
                'funeral_schedule' => $funeral_schedule->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }



        return redirect()->route('funeral_schedule.edit',['funeral_schedule' => $funeral_schedule->id ]);
    }


    public function render()
    {

        // dd($this->existingFiles);
        return view('livewire.funeral-schedule.funeral-schedule-edit',[
            'existingFiles' => $this->existingFiles,
        ])
        ->layout('layouts.app'); // <--- This sets the layout!
    }
}
