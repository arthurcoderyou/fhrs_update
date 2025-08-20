<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone ?? '';
        
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required',  ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    function formatForWhatsApp($phone)
    {
        return preg_replace('/[^0-9]/', '', $phone) . '@c.us';
    }


    public function isWhatsAppNumber()
    {
        $params = [
            'token' => '2adokm305iyvjkbj',
            $chatId = $this->formatForWhatsApp($this->phone), // returns "639123456789@c.us"
        ];

        $url = "https://api.ultramsg.com/instance122258/contacts/check?" . http_build_query($params);

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            // return ['success' => false, 'error' => $err];
            // Session::flash('phone-status', 'phone-invalid');
            // session()->flash('alert.error', $err );

            Session::flash('alert.error', $err );


        }

        $result = json_decode($response, true);
        if (!empty($result['status']) && $result['status'] === 'valid') {
            // return ['success' => true, 'valid' => true];

            // session()->flash('alert.success', 'Number is valid!');

            Session::flash('alert.success', 'Number is valid!' );
        }

        // return ['success' => true, 'valid' => false];
        // return redirect()->route('dashboard');
    }









}; ?>

<section>

    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />

            @php 
                // {{ !empty(Auth::user()->phone_verified_at) ? true : false }}
            @endphp
            <x-text-input   id="phone" wire:model="phone" :disabled="!empty(Auth::user()->phone_verified_at)" name="phone" type="text" class="mt-1 block w-full" required autocomplete="phone" />
            
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />

            <div class="flex justify-between  items-center my-1">
                 
                
                    
                @if(empty(Auth::user()->phone_verified_at))

                    <a href="{{ route('verification.whatsapp-otp') }}" wire:navigate
                    class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2  "
                    >Verify phone number</a>

                    <span class="text-red-500 text-sm font-medium uppercase">
                        Not verified
                    </span>
                @else
                     <span class="text-green-500 text-sm font-medium uppercase">
                        Verified
                    </span>
                @endif

            </div>

        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif

            @if(!empty(Auth::user()->email_verified_at))
                <span class="text-green-500 text-sm font-medium uppercase">
                    Verified
                </span>
            @endif

        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>


    <script>
    function checkPhone() {
        const input = document.getElementById('phone').value;

        // Use the global `libphonenumber` object
        const phoneNumber = libphonenumber.parsePhoneNumberFromString(input, 'US'); // Change 'US' to your default country

        const resultElement = document.getElementById('result');

        if (phoneNumber && phoneNumber.isValid()) {
            const whatsappFormat = phoneNumber.number.replace('+', '') + '@c.us';

            resultElement.innerHTML = `
                ✅ Valid number<br>
                📱 International: ${phoneNumber.formatInternational()}<br>
                🔗 WhatsApp ID: <strong>${whatsappFormat}</strong>
            `;
        } else {
            resultElement.innerHTML = "❌ Invalid phone number";
        }
    }
</script>


</section>
