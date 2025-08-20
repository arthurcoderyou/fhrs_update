<?php

namespace App\Livewire\Setting;

use App\Models\Setting;
use Livewire\Component;
use App\Events\SettingUpdated;
use App\Models\SettingOptions;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Events\PublicSettingUpdated;
use Illuminate\Support\Facades\Auth;

class SettingEdit extends Component
{


    public string $key = '';
    public string $value = '';
    public string $name = '';
    
    public $value_type;

    public array $setting_options = [ 
    ];

    public $value_types = [
        'text' => "Text",
        'long_text' => "Long Text",
        'number' => "Number",
        'selection' => "Selection of options",
    ];

    public $setting_id;

    public function mount(Setting $setting){

        $this->setting_id = $setting->id;

        // 👇 Load existing options
        $this->setting_options = $setting->setting_options->map(function ($option) {
            return $option->name;
        })->toArray();

        $this->key = $setting->key;
        $this->name = $setting->name; 
        $this->value_type = $setting->value_type;


    }

  
    


 
    public function updated($fields){

        $this->validateOnly($fields,[
            
            'key' => [
                'required', 'string', 'lowercase', 'max:255',
                Rule::unique('settings', 'key')->ignore($this->setting_id)
            ],
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('settings', 'name')->ignore($this->setting_id)
            ],

            'value' => ['required', ], 
            'value_type' => ['required']
        ]);

    }

     


    public function addSettingOption()
    {
        $this->setting_options[] = '';
    }

    public function removeSettingOption($index)
    {
        unset($this->setting_options[$index]);
        $this->setting_options = array_values($this->setting_options); // Reindex
    }




    /**
     * Handle record save
     */
    public function save()
    {

        // dd($this->setting_options);
        $this->validate([
           'key' => [
                'required', 'string', 'lowercase', 'max:255',
                Rule::unique('settings', 'key')->ignore($this->setting_id)
            ],
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('settings', 'name')->ignore($this->setting_id)
            ],

            // 'value' => ['required', ], 
            'value_type' => ['required']
        ]);

      
        $setting = Setting::find($this->setting_id);
        $setting->key = $this->key;
        $setting->name = $this->name; 
        $setting->value_type = $this->value_type;  
        $setting->updated_at = now();
        $setting->updated_by = Auth::user()->id;

        $setting->save();



        //delete previous setting options 
        if(!empty($setting->setting_options)){

            // dd($setting->setting_options);

            foreach($setting->setting_options as $option){
                $option->delete();
            }
        }




        if(!empty($this->setting_options)){
            foreach($this->setting_options as $key => $value){
                if($value !== ""){
                    $setting_option = new SettingOptions();
                    $setting_option->name = $value;
                    $setting_option->setting_id = $setting->id;
                    $setting_option->created_by = Auth::user()->id;
                    $setting_option->updated_by = Auth::user()->id;
                    $setting_option->save();
                }

                
            } 
        }
 

        $setting = Setting::where('id',$this->setting_id)->first();

        try {
            event(new SettingUpdated($setting));

        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send SettingUpdated event: ' . $e->getMessage(), [
                'setting' => $setting->id,
                'trace' => $e->getTraceAsString(),
            ]);
        } 


        try {
            event(new PublicSettingUpdated($setting));

        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicSettingUpdated event: ' . $e->getMessage(), [
                'setting' => $setting->id,
                'trace' => $e->getTraceAsString(),
            ]);
        } 

        

        // Alert::success('Success','New User created successfully');
        return redirect()->route('setting.index');
    }



    public function render()
    {
        return view('livewire.setting.setting-edit')
            ->layout('layouts.app'); // <--- This sets the layout!
    }
}
