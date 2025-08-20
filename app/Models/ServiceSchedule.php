<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity; 

class ServiceSchedule extends Model
{
    //
    //  Schema::create('service_schedules', function (Blueprint $table) {
        //     $table->id();

        //     // Foreign key to workers
        //     $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        //     // Recurring or not
        //     $table->boolean('is_recurring')->default(false);

        //     // If recurring: store days like ["monday", "wednesday"]
        //     $table->json('recurring_days')->nullable();

        //     // For both one-time and recurring
        //     $table->date('start_date');
        //     $table->date('end_date')->nullable();

        //     // Optional time range (e.g. for shift time)
        //     $table->time('start_time')->nullable();
        //     $table->time('end_time')->nullable();

        //     $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); // Creator of the schedule 

        //     $table->timestamps();
        // });

    use LogsActivity;

    
    protected static $logAttributes = [
        'user_id', 
        'is_recurring',
        'recurring_days', 
        'start_date', 
        'end_date',
        'start_time',
        'end_time',
        'created_by',
        'schedule_date'
    ]; // Log these attributes
    // protected static $logAttributes = [...] ensures that those fields are logged, even on deletion.

    protected static $logOnlyDirty = true; // Only log if values change
    // logOnlyDirty() means it will log only if something actually changed.
    
    
    protected static $logName = 'service schedule';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                 'user_id', 
                'is_recurring',
                'recurring_days', 
                'start_date', 
                'end_date',
                'start_time',
                'end_time',
                'created_by',
                'schedule_date'
            ])
            ->useLogName('service schedule')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Service schedule has been {$eventName}");
             
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = auth()->user(); // the actor

        $activity->properties = $activity->properties->merge([
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $actor = $user ? $user->name : 'System';
        $target = $this->user->name." on ".$this->schedule_date->format('M d Y'); // the user being affected

        $activity->description = "{$actor} has {$eventName} the service schedule for '{$target}'";
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id', 
        'is_recurring',
        'recurring_days', 
        'start_date', 
        'end_date',
        'start_time',
        'end_time',
        'created_by',
        'schedule_date'
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
            'schedule_date' => 'date',
            
            'start_time' => 'datetime:H:i:s',
            'end_time' => 'datetime:H:i:s',

            // 'start_time' => 'string',
            // 'end_time' => 'string',
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
     * Get user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }





}
