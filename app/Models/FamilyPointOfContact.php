<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity; 

class FamilyPointOfContact extends Model
{
    use SoftDeletes;
    /**
     * Schema::create('family_point_of_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funeral_schedule_id')->constrained()->onDelete('cascade');
            $table->string('phone');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
     * 
     */

    use LogsActivity;

    
    protected static $logAttributes = [
        'funeral_schedule_id', 
        'phone',
        'notes', 
    ]; // Log these attributes
    // protected static $logAttributes = [...] ensures that those fields are logged, even on deletion.

    protected static $logOnlyDirty = true; // Only log if values change
    // logOnlyDirty() means it will log only if something actually changed.
    
    
    protected static $logName = 'family_point_of_contacts';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'funeral_schedule_id', 
                'phone',
                'notes',
            ])
            ->useLogName('family_arrival')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Family point of contact record has been {$eventName}");
             
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = auth()->user(); // the actor

        $activity->properties = $activity->properties->merge([
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $actor = $user ? $user->name : 'System';
        $target = $this->funeral_schedule->name_of_person; // the user being affected

        $activity->description = "{$actor} has {$eventName} the family point of contact record on funeral for '{$target}'";
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'funeral_schedule_id', 
        'phone',
        'notes',
    ];

    

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // 'time' => 'datetime:H:i',
        ];
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
