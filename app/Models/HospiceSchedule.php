<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity; 

class HospiceSchedule extends Model
{
    /**
     *  Schema::create('hospice_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('name');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
     * 
     */

    use SoftDeletes;
 

    use LogsActivity;

    
    protected static $logAttributes = [
        'start_date', 
        'end_date',
        'name', 
        'created_by', 
        'updated_by', 
    ]; // Log these attributes
    // protected static $logAttributes = [...] ensures that those fields are logged, even on deletion.

    protected static $logOnlyDirty = true; // Only log if values change
    // logOnlyDirty() means it will log only if something actually changed.
    
    
    protected static $logName = 'hospice_schedule';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'start_date', 
                'end_date',
                'name', 
            ])
            ->useLogName('hospice_schedule')
            ->logOnlyDirty() 
            ->setDescriptionForEvent(fn(string $eventName) => "Hospice schedule has been {$eventName}");
             
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
        $target = $this->name; // the user being affected


        // // Check if it's a custom manual log event
        // $customEvent = $activity->properties['custom_event'] ?? null;

        // if ($customEvent === 'email_notification') {
        //     $notifiedEmail = $activity->properties['notified_user_email'] ?? 'unknown email';
        //     $activity->description = "{$actor} sent an email notification to {$notifiedEmail} for the funeral schedule of '{$target}'";
        // } else {
        //     // Default model events
        //     $activity->description = "{$actor} has {$eventName} the funeral schedule for '{$target}'";
        // }



        $activity->description = "{$actor} has {$eventName} the hospice schedule for '{$target}'";
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'start_date', 
        'end_date',
 
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
            'start_date' => 'date', 
            'end_date' => 'date', 
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

    /**
     * Get all of theFuneralSchedules
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function funeral_schedules()
    {
        return $this->hasMany(FuneralSchedule::class, 'hospice_schedule_id', 'id');
    }

}
