<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Setting extends Model
{
    use SoftDeletes;


    use LogsActivity;

    // public function up(): void
    // {
    //     Schema::create('settings', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('key')->unique();
    //         $table->string('value');
    //         $table->foreignId('created_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade'); 
    //         $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade')->onDelete('cascade'); 
    //         $table->softDeletes();
    //         $table->timestamps();
    //     });
    // }



    protected static $logAttributes = ['key', 'value','name']; // Log these attributes
    // protected static $logAttributes = [...] ensures that those fields are logged, even on deletion.

    protected static $logOnlyDirty = true; // Only log if values change
    // logOnlyDirty() means it will log only if something actually changed.
    
    
    protected static $logName = 'settings';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['key', 'value','name'])
            ->useLogName('settings')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Settings has been {$eventName}");
             
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

        $activity->description = "{$actor} has {$eventName} the settings '{$target}'";
    }




     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'key',
        'value',  
        'name',
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
     * Get all of the setting options for the Setting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function setting_options() 
    {
        return $this->hasMany(SettingOptions::class, 'setting_id', 'id');
    }


    public static function getFuneralScheduleDays(): int
    {
        $setting = self::where('key', 'funeral_schedule_days')->first();

        if ($setting && filter_var($setting->value, FILTER_VALIDATE_INT) !== false) {
            return (int) $setting->value;
        }

        // Default fallback if not set or invalid
        return 3;
    }



    public static function getPositionSetting(){    
        $setting = Setting::where('key','positions')
            ->first();


        if(empty($setting)){


            //get the global admin 
            $globalAdmin = User::role('Global Administrator')->first();


            $setting = Setting::create([
                'name' => 'Position Settings',
                'key' => 'positions',
                'created_by' => $globalAdmin->id,
                'updated_by' => $globalAdmin->id, 
            ]);

        }


        return $setting;

    }

    public static function getFontSizeSetting(){    
        $setting = Setting::where('key','font_size')
            ->first();


        if(empty($setting)){


            //get the global admin 
            $globalAdmin = User::role('Global Administrator')->first();


            $setting = Setting::create([
                'name' => 'Position Settings',
                'key' => 'font_size',
                'value' => '16', // default
                'created_by' => $globalAdmin->id,
                'updated_by' => $globalAdmin->id, 
            ]);

        }


        return $setting;

    }


    public static function getFontSetting($key){    
        $setting = Setting::where('key',$key)
            ->first();


        if(empty($setting)){ 
            //get the global admin 
            // $globalAdmin = User::role('Global Administrator')->first(); 
            $setting = Setting::create([
                'name' => 'Position Settings',
                'key' => $key,
                'value' => '16', // default
                // 'created_by' => $globalAdmin->id,
                // 'updated_by' => $globalAdmin->id, 
                'order' => Setting::max('order') + 1,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id, 
            ]);

        }


        return $setting;

    }


    // function to save display settings
    public static function saveDisplaySettings(array $settings)
    {
        foreach ($settings as $key => $value) {
            $setting = Setting::where('key', $key)->first();

            if (empty($setting)) {
                Setting::create([
                    'name'       => ucfirst(str_replace('_', ' ', $key)),
                    'key'        => $key,
                    'value'      => $value,
                    'order'      => Setting::max('order') + 1,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
            } else {
                $setting->update([
                    'value'      => $value,
                    'updated_by' => auth()->id(),
                ]);
            }
        }
    }




}
