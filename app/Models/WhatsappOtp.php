<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class WhatsappOtp extends Model
{
    protected $fillable = ['user_id', 'otp', 'expires_at', 'created_by'];

    protected $dates = ['expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }


    static public function generateOtpForUser(User $user): WhatsappOtp
    {
        $otp = rand(100000, 999999);

        return WhatsappOtp::create([
            'user_id' => $user->id,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10),
            'created_by' => Auth::id(),
        ]);
    }

}
