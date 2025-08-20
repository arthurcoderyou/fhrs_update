<?php

namespace App\Livewire\User;

use App\Models\User;
use Livewire\Component; 
use App\Events\UserCreated;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserCreate extends Component
{
    public string $name = '';
    public string $email = '';

    public ?string $phone = null;   // ✅ initialize + nullable
    public string $password = '';
    public $role;
    public string $password_confirmation = '';
    public function updated($fields){

        $this->validateOnly($fields,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required'],
            'phone' => ['nullable', 'unique:'.User::class]
        ]);

    }


    /**
     * Handle record save
     */
    public function save()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required'],
            'phone' => ['nullable', 'unique:'.User::class]
        ]);

        $password = Hash::make($this->password);


        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->email_verified_at = now();
        $user->phone = $this->phone;
        $user->phone_verified_at = now();
        $user->password = $password;
        $user->created_by = Auth::user()->id;
        $user->updated_by = Auth::user()->id;

        $user->save();

        if(!empty($this->role)){
            //add role
            $role = Role::find($this->role);
            $user->assignRole($role);
        }

        if(!empty($this->role)){
            //add role
            $role = Role::find($this->role);
            $user->assignRole($role);
        }

        try {
            //send email notification
             event(new UserCreated($user));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send UserCreated event: ' . $e->getMessage(), [
                'user' => $user->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }
       


        // Alert::success('Success','New User created successfully');
        return redirect()->route('user.index');
    }


    public function render()
    {

        $roles = Role::select('roles.*')
        ->whereNull('deleted_at');

        if(!Auth::user()->hasRole('Global Administrator')){
            $roles = $roles->whereNot('name', 'Global Administrator');
                
        } 
        
        $roles  = $roles->orderBy('name','asc')->get();
         

        return view('livewire.user.user-create',compact('roles'))
            ->layout('layouts.app'); // <--- This sets the layout!
    }
}
