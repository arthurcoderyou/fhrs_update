<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class SettingOptions extends Model
{
    
    use SoftDeletes;


    use LogsActivity;

    //  Schema::create('setting_options', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->foreignId('setting_id')->constrained('settings')->onUpdate('cascade')->onDelete('cascade'); 
    //         $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade'); 
    //         $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade'); 
    //         $table->timestamps();
    //     });



    protected static $logAttributes = ['name', 'setting_id']; // Log these attributes
    // protected static $logAttributes = [...] ensures that those fields are logged, even on deletion.

    protected static $logOnlyDirty = true; // Only log if values change
    // logOnlyDirty() means it will log only if something actually changed.
    
    
    protected static $logName = 'settings';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'setting_id'])
            ->useLogName('settings')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Setting options has been {$eventName}");
             
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = auth()->user(); // the actor

        $activity->properties = $activity->properties->merge([
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $actor = $user ? $user->name : 'System';
        $target = $this->name; // the name of the key being affected

        $activity->description = "{$actor} has {$eventName} the setting options '{$target}'";
    }




     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'setting_id',  
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
     * Get setting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting() 
    {
        return $this->belongsTo(Setting::class, 'setting_id', 'id');
    }

}
