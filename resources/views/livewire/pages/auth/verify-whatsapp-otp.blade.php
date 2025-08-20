<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Livewire\Actions\Logout;

new #[Layout('layouts.guest')] class extends Component 
{
    
    public string $name = ''; 
    public string $phone = '';
    public string $otp = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name; 
        $this->phone = Auth::user()->phone ?? '';


        // if there are no sent otp for the user
        if( empty(Auth::user()->latestActiveOtp()) ){

            //send an otp verification
            $this->sendVerification();
        }
        
        
    }


    /**
     * Send an phone verification notification to the current user.
     */
    public function sendVerification(): void
    {

        // dd($this->phone);
        $this->validate([ 
            'phone' => ['required',  ], 
        ]);


        $user = Auth::user();
        $user->phone = $this->phone;
        $user->save();

        if (!empty($user->phone_verified_at)) {
            $this->redirectIntended(default: route('profile', absolute: false));

            return;
        }

        // $user->sendEmailVerificationNotification();

        $this->sendWhatsAppOtpVerification();

        
    }


    public function sendWhatsAppOtpVerification(){
        $user = Auth::user();
        $otp = $user->getWhatsAppOTPVerification();

        // otp message
        $message = "Your verification code is: ".$otp->otp."\n\nPlease enter this code to verify your phone number.\nThis code is valid for 10 minutes.";

        // code to send whatsapp notification 
        try {
            $params = [
                'token' => '2adokm305iyvjkbj',
                'to' => $this->phone,
                'body' => $message,
            ];

           $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.ultramsg.com/instance122258/messages/chat",
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
                Session::flash('status', 'verification-otp-not-sent');
                
            } else {
                // echo $response;
                Session::flash('status', 'verification-otp-sent');
            }

            // Session::flash('status', 'verification-otp-sent');


        } catch (Exception $e) {
            // Catch any errors and return the error message
            // return "Error sending message: " . $e->getMessage();
              // For error message
            // session()->flash('alert.error', $e->getMessage());

            Session::flash('status', 'verification-otp-not-sent');


            // return redirect()->back();
            // abort(403, 'Unauthorized.');

            // return redirect()->route('setting.whatsapp.edit');
        } 



    }





    public function verifyOtp()
    {
        // Logic to verify OTP

        $user = Auth::user();

        $validated = $this->validate([ 
            'phone' => ['required',  ], 
            'otp' => ['required', 'min:6']
        ]);
 
        $otp = $user->getWhatsAppOTPVerification();


        if ($otp->otp == $this->otp) {
            Session::flash('alert.success', 'OTP Code Verified');
        }else{
            Session::flash('alert.error', 'Wrong OTP Code. Please try again');
        }

        $user->phone_verified_at = now();
        $user->save();


        return redirect()->route('profile');
 



        
    }

     
     /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
    

}; ?>
<div>

    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>


    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please verify your WhatsApp phone number by entering the OTP sent to your number.') }}
    </div>

    @if (session('status') == 'verification-otp-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('WhatsApp phone number verification otp code has been sent to the phone number you provided  ') }}
        </div>
    @elseif(session('status') == 'verification-otp-not-sent')
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ __('WhatsApp phone number verification otp code NOT sent to the phone number you provided  ') }}
        </div>
    @elseif (session('alert.success') )
        <div class="mb-4 font-medium text-sm text-green-600">
            {{  session('alert.success') }}
        </div>
    @elseif(session('alert.error') )
        <div class="mb-4 font-medium text-sm text-red-600">
            {{ session('alert.error') }}
        </div>

    @endif

    <form class="space-y-4 md:space-y-6" wire:submit="verifyOtp">
        <div>
            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 ">Phone</label>
            <input 
            type="text" 
            name="phone" 
            id="phone" 
            wire:model="phone"
            autocomplete="tel" 
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "   required="">
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div>
            <label for="otp" class="block mb-2 text-sm font-medium text-gray-900 ">OTP</label>
            <input 
            type="text" 
            name="otp" 
            id="otp" 
            wire:model="otp"
            autocomplete="one-time-code" 
            class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " required="">
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <x-primary-button type="submit">
            {{ __('Verify OTP') }}
        </x-primary-button>
    </form>

    <div class="mt-4 flex items-center justify-between">
        <x-secondary-button wire:click="sendVerification">
            {{ __('Resend OTP') }}
        </x-secondary-button>

        <button wire:click="logout" type="button" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Log Out') }}
        </button>
    </div>
</div>
