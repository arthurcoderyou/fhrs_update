<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Traits\HasRoles;
use Exception;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use SoftDeletes,HasFactory, Notifiable, HasRoles;
    

    protected static function booted()
    {
        static::deleting(function ($user) {
            // $user->posts()->delete();
            // $user->profile()->delete();
            // Add other relations as needed    
        });
    }

    use LogsActivity;

    
    protected static $logAttributes = ['name', 'email']; // Log these attributes
    // protected static $logAttributes = [...] ensures that those fields are logged, even on deletion.

    protected static $logOnlyDirty = true; // Only log if values change
    // logOnlyDirty() means it will log only if something actually changed.
    
    
    protected static $logName = 'user';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email','notification_enabled'])
            ->useLogName('user')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "User has been {$eventName}");
             
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $user = auth()->user(); // the actor

        $activity->properties = $activity->properties->merge([
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $actor = $user ? $user->name : 'System';
        $target = $this->name; // the user being affected

        $activity->description = "{$actor} has {$eventName} the user '{$target}'";
    }





    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'notification_enabled',
        'password',
        'created_by',
        'updated_by',
        'phone',
        'phone_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


 
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


    public function funeral_schedule_notifications()
    {
        return $this->hasMany(FuneralScheduleNotification::class);
    }

    //get the latest otp verification
    public function latestActiveOtp()
    {
        return WhatsappOtp::where('user_id', $this->id)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();
    }

    public function getWhatsAppOTPVerification(){

        $otp = $this->latestActiveOtp();
        // dd($otp);

        if(empty($otp)){
            $otp = WhatsappOtp::generateOtpForUser($this);
        }
        //  dd($otp);


        return $otp;
 

    }

    


    // user sending whatsapp notifications for whatsapp
    public function sendWhatsAppOtpVerification($message){
          

        // otp message
        // $message = "Your verification code is: ".$otp->otp." \n\nPlease enter this code to verify your phone number. This code is valid for 10 minutes.";

        // code to send whatsapp notification 
        try {
            $params = [
                'token' => 'pssissc0mo0ul3vr',
                'to' => $this->phone,
                'body' => $message,
            ];

           $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ultramsg.com/instance140118/messages/chat",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($params),
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                // echo "cURL Error #:" . $err;
                // Session::flash('status', 'verification-otp-not-sent');
                
            } else {
                // echo $response;
                // Session::flash('status', 'verification-otp-sent');
            }

            // Session::flash('status', 'verification-otp-sent');


        } catch (Exception $e) {
            // Catch any errors and return the error message
            // return "Error sending message: " . $e->getMessage();
              // For error message
            // session()->flash('alert.error', $e->getMessage());

            // Session::flash('status', 'verification-otp-not-sent');


            // return redirect()->back();
            // abort(403, 'Unauthorized.');

            // return redirect()->route('setting.whatsapp.edit');
        } 



    }



}
