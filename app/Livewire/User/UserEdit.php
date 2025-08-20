<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component;
use App\Events\UserUpdated;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserEdit extends Component
{

    public string $name = '';
    public string $email = '';
     public ?string $phone = null;   // ✅ initialize + nullable
    public string $password = '';
    public string $password_confirmation = '';

    public $role;
 

    public $user_id;
     

    public function mount(User $user){
        

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? null;
        $this->user_id = $user->id;
        $this->role = !empty($user->roles->first()->id) ? $user->roles->first()->id : null;

        $this->role_empty = $user->roles->isEmpty();

    }


    public function updated($fields){

          
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$this->user_id],
            'role' => ['required'],
            'phone' => ['nullable', 'unique:'.User::class.',phone,'.$this->user_id]
        ];
        
        if (!empty($this->password)) {
            $rules['password'] = ['string', 'confirmed', Rules\Password::defaults()];
        }
        
        $this->validateOnly($fields,$rules);

    }


    /**
     * Handle an incoming registration request.
     */
    public function save()
    {
         

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email,'.$this->user_id],
            'role' => ['required'],
            'phone' => ['nullable', 'unique:'.User::class.',phone,'.$this->user_id]
        ];
        
        if (!empty($this->password)) {
            $rules['password'] = ['string', 'confirmed', Rules\Password::defaults()];
        }
        
        $this->validate($rules);



        $user = User::where('id',$this->user_id)->first();

        


        $user->name = $this->name;
        $user->email = $this->email;
        if(empty($user->email_verified_at)){
            $user->email_verified_at = now();
        }
        $user->phone = $this->phone; 
        if(empty($user->phone_verified_at)){
            $user->phone_verified_at = now();
        }

        if(!empty($this->password)){

            $this->validate([
                'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ]);


            $password = Hash::make($this->password);
            $user->password = $password;
        }

        if(!empty($this->role)){
            //add role
            $role = Role::find($this->role);
            $user->assignRole($role);
        }

        if (!empty($this->role)) {
            $role = Role::find($this->role);
            if ($role) {
                // Remove previous roles before assigning a new one
                $user->syncRoles([$role->name]);
            }
        }
        

        $user->updated_at = now();
        $user->updated_by = Auth::user()->id;

        $user->save();
  
        try {
            //send email notification
            event(new UserUpdated($user));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send UserUpdated event: ' . $e->getMessage(), [
                'user' => $user->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }
        
        return redirect()->route('user.index');
    }


    public function render()
    {

        $roles = Role::select('roles.*')
            ->whereNull('deleted_at')
            ;

        if(!Auth::user()->hasRole('Global Administrator')){
            $roles = $roles->whereNot('name', 'Global Administrator');
                
        } 
        
        $roles  = $roles->orderBy('name','asc')->get();
         

        return view('livewire.user.user-edit',compact('roles'))
            ->layout('layouts.app'); // <--- This sets the layout!
    }
}
