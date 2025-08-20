<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity; 

class FuneralAttachments extends Model
{
    use SoftDeletes;

   

    use LogsActivity;

    
    protected static $logAttributes = [
        'funeral_schedule_id', 
        'attachment',
        'created_by',
        'updated_by', 
    ];
    // protected static $logAttributes = [...] ensures that those fields are logged, even on deletion.

    protected static $logOnlyDirty = true; // Only log if values change
    // logOnlyDirty() means it will log only if something actually changed.
    
    
    protected static $logName = 'funeral_attachment';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'funeral_schedule_id', 
                'attachment',
                'created_by',
                'updated_by', 
            ])
            ->useLogName('funeral_attachment')
            ->logOnlyDirty() 
            ->setDescriptionForEvent(fn(string $eventName) => "Funeral attachment has been {$eventName}");
             
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


        // // Check if it's a custom manual log event
        // $customEvent = $activity->properties['custom_event'] ?? null;

        // if ($customEvent === 'email_notification') {
        //     $notifiedEmail = $activity->properties['notified_user_email'] ?? 'unknown email';
        //     $activity->description = "{$actor} sent an email notification to {$notifiedEmail} for the funeral schedule of '{$target}'";
        // } else {
        //     // Default model events
        //     $activity->description = "{$actor} has {$eventName} the funeral schedule for '{$target}'";
        // }



        $activity->description = "{$actor} has {$eventName} the funeral attachment for '{$target}'";
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'funeral_schedule_id', 
        'attachment',
        'created_by',
        'updated_by', 
    ];

    
 

 
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
     * Get funeral_schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function funeral_schedule() 
    {
        return $this->belongsTo(FuneralSchedule::class, 'funeral_schedule_id', 'id');
    }
}
