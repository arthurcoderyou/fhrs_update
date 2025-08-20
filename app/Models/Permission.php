<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;

class Permission extends SpatiePermission
{
    use LogsActivity, SoftDeletes;

    protected $fillable = [
        'name',
        'guard_name',
        'module',
    ];
    

    protected static $logName = 'permission'; // ✅ Correct log name
    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'guard_name'])
            ->useLogName('permission') // ✅ Correct log name
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Permission has been {$eventName}");
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = auth()->user();

        $activity->properties = $activity->properties->merge([
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $actor = $user ? $user->name : 'System';
        $target = $this->name;

        $activity->description = "{$actor} has {$eventName} the permission '{$target}'";
    }
}