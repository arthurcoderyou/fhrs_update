<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuneralScheduleNotification extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'funeral_schedule_id',
        'user_id',  

        'notified_at',  
    ];

    

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [ 
            'notified_at' => 'datetime:H:i', 
        ];
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function funeralSchedule()
    {
        return $this->belongsTo(FuneralSchedule::class);
    }


}
