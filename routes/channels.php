<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('users', function ($user) { 
    
    return Auth::check();

});


Broadcast::channel('activity_logs', function ($activity_log) { 
    
    return Auth::check();

});


Broadcast::channel('roles', function ($role) { 
    
    return Auth::check();

});

Broadcast::channel('permissions', function ($permission) { 
    
    return Auth::check();

});

Broadcast::channel('funeral_schedules', function ($funeral_schedule) { 
    
    return Auth::check();

});

Broadcast::channel('hospice_schedules', function ($hospice_schedule) { 
    
    return Auth::check();

});


Broadcast::channel('service_schedules', function ($hospice_schedule) { 
    
    return Auth::check();

});


Broadcast::channel('settings', function ($setting) { 
    
    return Auth::check();

});

Broadcast::channel('dashboard', function ($setting) { 
    
    return Auth::check();

});