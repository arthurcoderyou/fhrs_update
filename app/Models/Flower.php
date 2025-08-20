<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity; 
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;



class Flower extends Model
{
    /**
     * Schema::create('flowers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funeral_schedule_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
     * 
     */



    use SoftDeletes;
     

    use LogsActivity;

    
    protected static $logAttributes = [
        'funeral_schedule_id', 
        'name',
        'notes', 
    ]; // Log these attributes
    // protected static $logAttributes = [...] ensures that those fields are logged, even on deletion.

    protected static $logOnlyDirty = true; // Only log if values change
    // logOnlyDirty() means it will log only if something actually changed.
    
    
    protected static $logName = 'flowers';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'funeral_schedule_id', 
                'name',
                'notes',
            ])
            ->useLogName('equipment')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Flower has been {$eventName}");
             
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

        $activity->description = "{$actor} has {$eventName} the flower on funeral for '{$target}'";
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'funeral_schedule_id', 
        'name',
        'notes',
    ];

    

     

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
