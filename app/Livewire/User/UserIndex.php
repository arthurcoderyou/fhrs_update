<?php

namespace App\Livewire\User;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserIndex extends Component
{

    use WithFileUploads;
    use WithPagination;

    protected $listeners = [
        'userCreated' => '$refresh',
        'userUpdated' => '$refresh',
        'userDeleted' => '$refresh', 
    ];
    public $search = '';
    public $sort_by = '';

    public $sort_filters = [
        "Name A - Z",
        "Name Z - A",
        "Email A - Z",
        "Email Z - A",
        "Latest Added",
        "Oldest Added",
        "Latest Updated",
        "Oldest Updated",
    ];
    public $record_count = 10;

    public $selected_records = [];
    public $selectAll = false;

    public $count = 0;

    public $selected_role; 

    public $account_password;
    public $account_password_verified = false;
 
    public $selected_record = 0;
    
    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selected_records = User::pluck('id')->toArray(); // Select all records
        } else {
            $this->selected_records = []; // Deselect all
        }

        $this->count = count($this->selected_records);
 

    }

    public function updateSelectedCount()
    {
        // Update the count when checkboxes are checked or unchecked
        $this->count = count($this->selected_records);
    }


    public function select_record($record_id){
        $this->selected_record = $record_id;
    }  

 
    
  
    public function delete()
    { 
 
        $user = User::where('id',$this->selected_record)->first(); 
        $user->delete(); 
 

        try {
            //send email notification
            event(new UserDeleted());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send UserDeleted event: ' . $e->getMessage(), [
                'user' => $user->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

    }


    public function deleteAll(){
      
        // User::whereIn('id', $this->selected_records)->delete();

        if(!empty($this->selected_records)){
            foreach($this->selected_records as $selected_record_id){
                $user = User::find($selected_record_id);

                $user->delete();

            }
        }

        $this->selected_records = []; // Reset the selected records array
         
        try {
            //send email notification
            event(new UserDeleted());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send UserDeleted event: ' . $e->getMessage(), [
                'user' => $user->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }

        
 
    }




    // get the user list
    public function getUsersProperty()
    {

        $users = User::select('users.*');


        if (!empty($this->search)) {
            $search = $this->search;


            $users = $users->where(function($query) use ($search){
                $query =  $query->where('users.name','LIKE','%'.$search.'%')
                    ->orWhere('users.email','LIKE','%'.$search.'%');
            });


        }
 
        $users = $users->when($this->selected_role, function ($query) {
            // $query->whereHas('roles', function ($roleQuery) {
            //     $roleQuery->where('id', $this->selected_role);
            // });

            if ($this->selected_role === 'no_role') {
                // Users without roles
                $query->whereDoesntHave('roles');
            } else {
                // Users with the selected role
                $query->whereHas('roles', function ($roleQuery) {
                    $roleQuery->where('id', $this->selected_role);
                });
            }
        });

         
        
        // Find the role
        $role = Role::where('name', 'Global Administrator')->first();

        if ($role) {
            // Get user IDs only if role exists
            $dsiGodAdminUserIds = $role->users()->pluck('id');
        } else {
            // Set empty array if role doesn't exist
            $dsiGodAdminUserIds = [];
        }


        // if(!Auth::user()->hasRole('Global Administrator')){
        //     $users =  $users->where('users.created_by','=',Auth::user()->id);
        // }

        // Adjust the query
        if (!Auth::user()->hasRole('Global Administrator') && !Auth::user()->hasRole('Administrator')) {
            $users = $users->where('users.created_by', '=', Auth::user()->id);
        }
        
        if(!Auth::user()->hasRole('Global Administrator')){
            $users = $users->whereNotIn('users.id', $dsiGodAdminUserIds);
        } 
            
        


        // dd($this->sort_by);
        if(!empty($this->sort_by) && $this->sort_by != ""){
            // dd($this->sort_by);
            switch($this->sort_by){

                case "Name A - Z":
                    $users =  $users->orderBy('users.name','ASC');
                    break;

                case "Name Z - A":
                    $users =  $users->orderBy('users.name','DESC');
                    break;

                case "Email A - Z":
                    $users =  $users->orderBy('users.email','ASC');
                    break;

                case "Email Z - A":
                    $users =  $users->orderBy('users.email','DESC');
                    break;
                /**
                 * "Latest" corresponds to sorting by created_at in descending (DESC) order, so the most recent records come first.
                 * "Oldest" corresponds to sorting by created_at in ascending (ASC) order, so the earliest records come first.
                 */

                case "Latest Added":
                    $users =  $users->orderBy('users.created_at','DESC');
                    break;

                case "Oldest Added":
                    $users =  $users->orderBy('users.created_at','ASC');
                    break;

                case "Latest Updated":
                    $users =  $users->orderBy('users.updated_at','DESC');
                    break;

                case "Oldest Updated":
                    $users =  $users->orderBy('users.updated_at','ASC');
                    break;
                default:
                    $users =  $users->orderBy('users.updated_at','DESC');
                    break;

            }


        }else{
            $users =  $users->orderBy('users.updated_at','DESC');

        }



        $this->user_count = $users->count();

        $users = $users->paginate($this->record_count);



        return $users;
    }

    public function getRolesProperty(){
        $roles = Role::select('roles.*')
        ->whereNull('deleted_at');

        if(!Auth::user()->hasRole('Global Administrator')){
            $roles = $roles->whereNot('name', 'Global Administrator');
                
        }  

        return $roles->get();

    
    }

    public function refresh()
    {
        return $this->redirectRoute('user.index', navigate: true);
    }


    /** Actions with Password Confirmation panel */
        public $passwordConfirm = '';
        public $passwordError = null;


        /** Delete Confirmation  */
            public $confirmingDelete = false; // closes the confirmation delete panel
            
            public $recordId = null; 
            public function confirmDelete($recordId)
            {
                $this->confirmingDelete = true;
                $this->recordId = $recordId;
                $this->passwordConfirm = '';
                $this->passwordError = null;
            }

            public function executeDelete()
            {
                if (!Hash::check($this->passwordConfirm, auth()->user()->password)) {
                    $this->passwordError = 'Incorrect password.';
                    return;
                }

                $this->selected_record = $this->recordId;

                // delete the record
                $this->delete();

                $this->reset(['confirmingDelete', 'passwordConfirm', 'recordId', 'passwordError','selected_record']); 
            }

        /** ./ Delete Confirmation */

    /** ./ Actions with Password Confirmation panel */



    public function toggleNotification($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->notification_enabled = !$user->notification_enabled;
            $user->save();
        }

        $user = User::where('id',$user->id)->first();

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
 
        return view('livewire.user.user-index',[
                'users' => $this->users,
                'roles' => $this->roles
            ])
            ->layout('layouts.app'); // <--- This sets the layout!
    }
}
