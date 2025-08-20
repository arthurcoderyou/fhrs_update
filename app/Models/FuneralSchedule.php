<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpKernel\Fragment\FragmentUriGeneratorInterface; 

class FuneralSchedule extends Model
{
 
    use SoftDeletes;

    // Schema::create('funeral_schedules', function (Blueprint $table) {
    //     $table->id();
    //     $table->longText('name_of_person');
    //     $table->date('date');
    //     $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
    //     $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
    //     $table->softDeletes();
    //     $table->timestamps();
    // });


    protected static function booted()
    {
        static::deleting(function ($funeralSchedule) {
            // Delete family arrivals
            $funeralSchedule->familyArrivals()->delete();

            // Delete flowers
            $funeralSchedule->flowers()->delete();

            // Delete equipments
            $funeralSchedule->equipments()->delete();

            // Delete each attachment file and then the record
            foreach ($funeralSchedule->attachments as $attachment) {
                $filePath = storage_path("app/public/uploads/funeral_attachments/{$attachment->attachment}");

                if (file_exists($filePath)) {
                    @unlink($filePath); // delete file
                }

                $attachment->delete(); // delete record
            }
        });
    }


    use LogsActivity;

    
    protected static $logAttributes = [
        'name_of_person', 
        'date',
        'mass_time',
        'public_viewing_start',
        'public_viewing_end',
        'family_viewing_start',
        'family_viewing_end',
        'burial_cemetery',
        'burial_location',
        'hearse',
        'funeral_director',
        'co_funeral_director',

        'hospice_schedule_id',
        'folder',
    ]; // Log these attributes
    // protected static $logAttributes = [...] ensures that those fields are logged, even on deletion.

    protected static $logOnlyDirty = true; // Only log if values change
    // logOnlyDirty() means it will log only if something actually changed.
    
    
    protected static $logName = 'funeral_schedule';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name_of_person', 
                'date',
                'mass_time',
                'public_viewing_start',
                'public_viewing_end',
                'family_viewing_start',
                'family_viewing_end',
                'burial_cemetery',
                'burial_location',
                'hearse',
                'funeral_director',
                'co_funeral_director',
                'folder',
            ])
            ->useLogName('funeral_schedule')
            ->logOnlyDirty() 
            ->setDescriptionForEvent(fn(string $eventName) => "Funeral schedule has been {$eventName}");
             
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        // $user = auth()->user(); // the actor
        $user = $activity->causer; // use causer, not auth()

        $activity->properties = $activity->properties->merge([
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $actor = $user ? $user->name : 'System';
        $target = $this->name_of_person; // the user being affected


        // Check if it's a custom manual log event
        $customEvent = $activity->properties['custom_event'] ?? null;

        if ($customEvent === 'email_notification') {
            $notifiedEmail = $activity->properties['notified_user_email'] ?? 'unknown email';
            $activity->description = "{$actor} sent an email notification to {$notifiedEmail} for the funeral schedule of '{$target}'";
        } else {
            // Default model events
            $activity->description = "{$actor} has {$eventName} the funeral schedule for '{$target}'";
        }



        // $activity->description = "{$actor} has {$eventName} the funeral schedule for '{$target}'";
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name_of_person',
        'date',  

        'mass_time',
        'public_viewing_start',
        'public_viewing_end',
        'family_viewing_start',
        'family_viewing_end',
        'burial_cemetery',
        'burial_location',
        'hearse',
        'funeral_director',
        'co_funeral_director',

        'hospice_schedule_id',
        'folder',

        'created_by',
        'updated_by'
    ];

    

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'date', 
            'mass_time' => 'datetime:H:i',
            'public_viewing_start' => 'datetime:H:i',
            'public_viewing_end' => 'datetime:H:i',
            'family_viewing_start' => 'datetime:H:i',
            'family_viewing_end' => 'datetime:H:i',
        ];
    }


 
    /**
     * Get creator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator() 
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Get updator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updator() 
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }




    public function familyArrivals()
    {
        return $this->hasMany(FamilyArrival::class);
    }

    public function familyPointOfContact()
    {
        return $this->hasMany(FamilyPointOfContact::class);
    }

    public function flowers()
    {
        return $this->hasMany(Flower::class);
    }


    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

   
    /**
     * Get hospice_schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospice_schedule() 
    {
        return $this->belongsTo(HospiceSchedule::class, 'hospice_schedule_id', 'id');
    }


    /**
     * Get all of the funeral attachments for the FuneralSchedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attachments()
    {
        return $this->hasMany(FuneralAttachments::class, 'funeral_schedule_id', 'id');
    }


    public function notifications()
    {
        return $this->hasMany(FuneralScheduleNotification::class);
    }



}
