<?php

use App\Livewire\Dashboard;
use App\Livewire\Dashboard\AdminDashboard;
use App\Livewire\Dashboard\ScheduleDisplay;
use App\Livewire\Dashboard\ScheduleWidget;
use App\Livewire\Role\RoleEdit;
use App\Livewire\ServiceSchedule\ServiceScheduleCreate;
use App\Livewire\ServiceSchedule\ServiceScheduleEdit;
use App\Livewire\ServiceSchedule\ServiceScheduleIndex;
use App\Livewire\ServiceSchedule\ServiceScheduleShow;
use App\Livewire\Setting\WhatsappMessagingSettings;
use App\Livewire\User\UserEdit;
use App\Livewire\Role\RoleIndex;
use App\Livewire\Role\RoleCreate;
use App\Livewire\User\UserCreate;
use App\Livewire\User\UserIndex; 
use App\Livewire\Setting\SettingEdit;
use App\Livewire\Setting\SettingShow;
use Illuminate\Support\Facades\Route;
use App\Livewire\Role\RolePermissions;
use App\Livewire\Setting\SettingCreate;
use App\Livewire\Permission\PermissionEdit;
use App\Livewire\Permission\PermissionIndex;
use App\Livewire\Permission\PermissionCreate;
use App\Http\Controllers\AttachmentController;
use App\Livewire\ActivityLog\ActivityLogIndex;
use App\Livewire\FuneralService\FuneralServiceEdit;
use App\Livewire\FuneralService\FuneralServiceIndex;
use App\Livewire\FuneralSchedule\FuneralScheduleEdit;
use App\Livewire\FuneralSchedule\FuneralScheduleShow;
use App\Livewire\FuneralService\FuneralServiceCreate;
use App\Livewire\HospiceSchedule\HospiceScheduleEdit;
use App\Livewire\HospiceSchedule\HospiceScheduleShow;
use App\Livewire\FuneralSchedule\FuneralScheduleIndex;
use App\Livewire\HospiceSchedule\HospiceScheduleIndex;
use App\Livewire\FuneralSchedule\FuneralScheduleCreate;
use App\Livewire\HospiceSchedule\HospiceScheduleCreate;




Route::view('/', 'welcome')->name('welcome');




Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/funeral_schedule/public/{funeral_schedule}/show', ScheduleDisplay::class)
    // ->middleware(['role_or_permission:Global Administrator,funeral schedule show'])
    ->name('funeral_schedule.public.show');

Route::get('/funeral_schedule', FuneralScheduleIndex::class)
        // ->middleware(['role_or_permission:Global Administrator,funeral schedule list'])
        ->name('funeral_schedule.index');

Route::get('/funeral_schedule/{funeral_schedule}/show', FuneralScheduleShow::class)
    // ->middleware(['role_or_permission:Global Administrator,funeral schedule show'])
    ->name('funeral_schedule.show');


Route::middleware(['auth', 'verified', 
    // 'throttle:3'
    ])->group(function () {
    // Your routes here
    // Route::get('/dashboard', function () {
    //     // Dashboard content
    // });

    Route::get('/user', UserIndex::class)
        ->middleware(['role_or_permission:Global Administrator,user list'])
        ->name('user.index');
    Route::get('/user/create', UserCreate::class)
        ->middleware(['role_or_permission:Global Administrator,user create'])
        ->name('user.create');
    Route::get('/user/{user}/edit', UserEdit::class)
        ->middleware(['role_or_permission:Global Administrator,user edit'])
        ->name('user.edit');


    Route::get('/activity_log', ActivityLogIndex::class)->name('activity_log.index');
 
    Route::get('/role', RoleIndex::class)
        ->middleware(['role_or_permission:Global Administrator,role list'])
        ->name('role.index');
    Route::get('/role/create', RoleCreate::class)
        ->middleware(['role_or_permission:Global Administrator,role create'])
        ->name('role.create');
    Route::get('/role/{role}/edit', RoleEdit::class)
        ->middleware(['role_or_permission:Global Administrator,role edit'])
        ->name('role.edit'); 
    Route::get('/role/{role}/permissions', RolePermissions::class)
        ->middleware(['role_or_permission:Global Administrator,role add permission'])
        ->name('role.permissions');

    Route::get('/permission', PermissionIndex::class)
        ->middleware(['role_or_permission:Global Administrator,permission create'])
        ->name('permission.index');
    Route::get('/permission/create', PermissionCreate::class)
        ->middleware(['role_or_permission:Global Administrator,permission create'])
        ->name('permission.create');
    Route::get('/permission/{permission}/edit', PermissionEdit::class)
        ->middleware(['role_or_permission:Global Administrator,permission create'])
        ->name('permission.edit');

    Route::get('/setting', SettingShow::class)
        ->middleware(['role_or_permission:Global Administrator,setting list'])
        ->name('setting.index');
    Route::get('/setting/create', SettingCreate::class)
        ->middleware(['role_or_permission:Global Administrator,setting create'])
        ->name('setting.create');
    Route::get('/setting/{setting}/edit', SettingEdit::class)
        ->middleware(['role_or_permission:Global Administrator,setting edit'])
        ->name('setting.edit');

    Route::get('/setting/whatsapp-setting', WhatsappMessagingSettings::class)
        ->middleware(['role_or_permission:Global Administrator,setting create'])
        ->name('setting.whatsapp.edit');
    
    // Route::get('/funeral_service', FuneralServiceIndex::class)->name('funeral_service.index');
    // Route::get('/funeral_service/create', FuneralServiceCreate::class)->name('funeral_service.create');
    // Route::get('/funeral_service/{funeral_service}/edit', FuneralServiceEdit::class)->name('funeral_service.edit');

    // Route::get('/funeral_schedule', FuneralScheduleIndex::class)
    //     ->middleware(['role_or_permission:Global Administrator,funeral schedule list'])
    //     ->name('funeral_schedule.index');
    Route::get('/funeral_schedule/create', FuneralScheduleCreate::class)
        ->middleware(['role_or_permission:Global Administrator,funeral schedule create'])
        ->name('funeral_schedule.create');
    Route::get('/funeral_schedule/{funeral_schedule}/edit', FuneralScheduleEdit::class)
        ->middleware(['role_or_permission:Global Administrator,funeral schedule edit'])
        ->name('funeral_schedule.edit');
    // Route::get('/funeral_schedule/{funeral_schedule}/show', FuneralScheduleShow::class)
    //     ->middleware(['role_or_permission:Global Administrator,funeral schedule show'])
    //     ->name('funeral_schedule.show');

    // editing of the public full page dashboard
    Route::get('/funeral_schedule/public_edit', AdminDashboard::class)
        ->middleware(['role_or_permission:Global Administrator,setting list'])
        ->name('funeral_schedule.public.edit');



    Route::get('/service_schedule', ServiceScheduleIndex::class)
        ->middleware(['role_or_permission:Global Administrator,service schedule list'])
        ->name('service_schedule.index');
    Route::get('/service_schedule/create', ServiceScheduleCreate::class)
        ->middleware(['role_or_permission:Global Administrator,service schedule create'])
        ->name('service_schedule.create');
    Route::get('/service_schedule/{service_schedule}/edit', ServiceScheduleEdit::class)
        ->middleware(['role_or_permission:Global Administrator,service schedule edit'])
        ->name('service_schedule.edit');
    Route::get('/service_schedule/{service_schedule}/show', ServiceScheduleShow::class)
        ->middleware(['role_or_permission:Global Administrator,service schedule show'])
        ->name('service_schedule.show');


    Route::get('/hospice_schedule', HospiceScheduleIndex::class) 
        ->middleware(['role_or_permission:Global Administrator,hospice schedule list'])
        ->name('hospice_schedule.index');
    Route::get('/hospice_schedule/create', HospiceScheduleCreate::class)
        ->middleware(['role_or_permission:Global Administrator,hospice schedule create'])
        ->name('hospice_schedule.create');
    Route::get('/hospice_schedule/{hospice_schedule}/edit', HospiceScheduleEdit::class)
        ->middleware(['role_or_permission:Global Administrator,hospice schedule edit'])    
        ->name('hospice_schedule.edit');
    Route::get('/hospice_schedule/{hospice_schedule}/show', HospiceScheduleShow::class)
        ->middleware(['role_or_permission:Global Administrator,hospice schedule show'])
        ->name('hospice_schedule.show');

    Route::get('/ftp-download/{id}', [AttachmentController::class, 'ftpDownload'])->name('ftp.download');



});











require __DIR__.'/auth.php';
