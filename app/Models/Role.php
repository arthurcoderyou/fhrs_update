<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use LogsActivity,SoftDeletes;

    protected static $logName = 'role';

    protected static $logOnlyDirty = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'guard_name'])
            ->useLogName('role')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Role has been {$eventName}");
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

        $activity->description = "{$actor} has {$eventName} the role '{$target}'";
    }
}