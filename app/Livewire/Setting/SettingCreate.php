<?php

namespace App\Livewire\Setting;

use App\Models\Setting;
use Livewire\Component;
use App\Events\SettingCreated;
use App\Models\SettingOptions;
use Illuminate\Support\Facades\Log;
use App\Events\PublicSettingCreated;
use Illuminate\Support\Facades\Auth;

class SettingCreate extends Component
{

    public string $key = '';
    public string $value = '';
    public string $name = '';
    
    public $value_type;

    public array $setting_options = [
        0 => ''
    ];

    public $value_types = [
        'text' => "Text",
        'long_text' => "Long Text",
        'number' => "Number",
        'selection' => "Selection of options",
    ];
 
    public function updated($fields){

        $this->validateOnly($fields,[
            
            'key' => ['required', 'string', 'lowercase',   'max:255', 'unique:'.Setting::class],
            'name' => ['required', 'string',  'max:255', 'unique:'.Setting::class],
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
        $this->validate([
            'key' => ['required', 'string', 'lowercase',   'max:255', 'unique:'.Setting::class],
            'name' => ['required', 'string',  'max:255', 'unique:'.Setting::class],
            // 'value' => ['required', ], 
            'value_type' => ['required']
        ]);

      
        $setting = new Setting();
        $setting->key = $this->key;
        $setting->name = $this->name; 
        $setting->order = Setting::max('order') + 1; 
        $setting->value_type = $this->value_type;  
        $setting->created_by = Auth::user()->id;
        $setting->updated_by = Auth::user()->id;

        $setting->save();

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
 

        try {
            event(new SettingCreated($setting));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send SettingCreated event: ' . $e->getMessage(), [
                'setting' => $setting->id,
                'trace' => $e->getTraceAsString(),
            ]);
        } 

        try {
            event(new PublicSettingCreated($setting));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicSettingCreated event: ' . $e->getMessage(), [
                'setting' => $setting->id,
                'trace' => $e->getTraceAsString(),
            ]);
        } 
        


        // Alert::success('Success','New User created successfully');
        return redirect()->route('setting.index');
    }


    


    public function render()
    {
        return view('livewire.setting.setting-create')
            ->layout('layouts.app'); // <--- This sets the layout!
    }
}
