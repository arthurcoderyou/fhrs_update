<?php

namespace App\Livewire\Setting;

use App\Models\Setting;
use Livewire\Component;
use App\Events\SettingDeleted;
use App\Events\SettingUpdated;
use Illuminate\Support\Facades\Log;
use App\Events\PublicSettingDeleted;
use App\Events\PublicSettingUpdated;
use Illuminate\Support\Facades\Auth;

class SettingShow extends Component
{

    protected $listeners = [
        'settingCreated' => 'refresh',
        'settingUpdated' => 'refresh',
        'settingDeleted' => 'refresh',  
    ];


    public $settings = [];

    public function mount()
    {
        $this->settings = $this->loadSettingsProperty();
 
    }


    
    public function refresh(){
        $this->settings = $this->loadSettingsProperty();
    }


    public function loadSettingsProperty(){
        $query = Setting::query();
        
        if (!Auth::user()->hasRole('Global Administrator')) {
            $query = $query->whereNot('key','positions')
                ->whereNot('key','footer_title')
                ;
        }


        $query = $query->orderBy('order','ASC')
            ->get()->mapWithKeys(function ($setting) {
            return [
                $setting->key => [
                    'id' => $setting->id,
                    'name' => $setting->name,
                    'value' => $setting->value,
                    'type' => $setting->value_type,
                    'order' => $setting->order,
                    'options' => $setting->value_type === 'selection'
                        ? \App\Models\SettingOptions::where('setting_id', $setting->id)->pluck('name')->toArray()
                        : [],
                ]
            ];
        })->toArray();

        return $query;
 
    }


    public function updatedSettings($value, $key)
    {

        // dd($key);
 
        // key: settings.notification_frequency.value
        $keyParts = explode('.', $key);
        $settingKey = $keyParts[0] ?? null;

        // dd($settingKey);

        if (!$settingKey) return;



        $setting = Setting::where('key', $settingKey)->first();

        // dd($setting);

        if ($setting) {
            $setting->value = $value;
            $setting->updated_by = auth()->id() ?? 1;
            $setting->save();   
 

            $setting = Setting::where('id',$setting->id)->first();
            
            
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
            


        }




    }


    public function delete($setting_id){

        $setting = Setting::find($setting_id);

        $setting = Setting::where('id',$setting_id)->first();

        try {
            event(new SettingDeleted($setting));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send SettingDeleted event: ' . $e->getMessage(), [
                'setting' => $setting->id,
                'trace' => $e->getTraceAsString(),
            ]);
        } 

        try {
            event(new PublicSettingDeleted($setting));
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicSettingDeleted event: ' . $e->getMessage(), [
                'setting' => $setting->id,
                'trace' => $e->getTraceAsString(),
            ]);
        } 


        $setting->delete();

        

    }



    public function save()
    {

        
    }


    /**
     * Computed (live) property for last order
     */
    public function getLastOrderProperty()
    {
        // return Reviewer::where('document_type_id', $this->document_type_id)->count();
        $lastOrder = Setting::query();
            if (!Auth::user()->hasRole('Global Administrator')) {
            $lastOrder = $lastOrder->whereNot('key','positions')
                ->whereNot('key','footer_title')
                ;
            }   
           $lastOrder = $lastOrder->max('order');

           return $lastOrder;
    }



   
     
    public function updateOrder($setting_id, $order, $direction)
    {
        if ($direction == "move_up") {
            $prev_setting = Setting::where('order', '<', $order)
                ->orderBy('order', 'DESC')
                ->first();

            if ($prev_setting) {
                // Swap the orders
                $current_setting = Setting::find($setting_id);
                $tempOrder = $current_setting->order;

                $current_setting->order = $prev_setting->order;
                $prev_setting->order = $tempOrder;

                $current_setting->save();
                $prev_setting->save();
            }

        } elseif ($direction == "move_down") {
            $next_setting = Setting::where('order', '>', $order)
                ->orderBy('order', 'ASC')
                ->first();

            if ($next_setting) {
                $current_setting = Setting::find($setting_id);
                $tempOrder = $current_setting->order;

                $current_setting->order = $next_setting->order;
                $next_setting->order = $tempOrder;

                $current_setting->save();
                $next_setting->save();
            }
        }

        $this->resetOrder();
    }



    public function resetOrder( )
    {
        $reviewers = Setting::orderBy('order', 'ASC')
            ->get();
    
        foreach ($reviewers as $index => $reviewer) {
            $reviewer->order = $index + 1;
            $reviewer->save();
        }


        $this->settings = $this->loadSettingsProperty();
        
    }
     

 




    public function render()
    {
        // dd($this->settings);
        return view('livewire.setting.setting-show',[
            'settings' => $this->settings,
            'lastOrder' => $this->lastOrder,
        ])
            ->layout('layouts.app'); // <--- This sets the layout!
    }
}
