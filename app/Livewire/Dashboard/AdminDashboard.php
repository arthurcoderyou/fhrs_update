<?php

namespace App\Livewire\Dashboard;

use App\Models\Setting;
use Livewire\Component;
use App\Models\FuneralSchedule;
use App\Events\DashboardUpdated;
use Illuminate\Support\Facades\Log;
use App\Events\PublicDashboardUpdated;
use Illuminate\Support\Facades\Auth;  

class AdminDashboard extends Component
{

    protected $listeners = [
        'funeralScheduleCreated' => 'refresh',
        'funeralScheduleUpdated' => 'refresh',
        'funeralScheduleDeleted' => 'refresh',
        'dashboardUpdated' => 'refresh', 
    ];

    public $schedule;
    // public $positions = [
    //     'name_of_person',
    //     'date',
    //     'mass_time',
    //     'public_viewing',
    //     'family_viewing',
    //     'burial_cemetery',
    //     'burial_location',
    //     'hearse',
    //     'funeral_director',
    //     'co_funeral_director',
    // ];


    // options that can be added 
    public $options = [
        'name_of_person',
        'date',
        'mass_time',
        'public_viewing',
        'family_viewing',
        'burial_cemetery',
        'burial_location',
        'hearse',
        'funeral_director',
        'co_funeral_director',
        'family_arrival',
        'flowers',
        'equipments',
        'point_of_contact',
        'attachments',
    ];


    // data on each option
    public array $data = [
        'name_of_person' => 'John Doe',
        'date' => 'May 29 2025',
        'mass_time' => '12:00 PM',
        'public_viewing' => '12:00 PM to 03:00 PM',
        'family_viewing' => '12:00 PM to 02:00 PM',
        'burial_cemetery' => 'Phil Cemetery',
        'burial_location' => 'PH',
        'hearse' => 'Wagon Class A',
        'funeral_director' => 'Arnold',
        'co_funeral_director' => 'Mark Rode',
        'family_arrival' => [
            '10:00 AM Mother Arrived',
            '12:00 PM Father Arrived',
            '12:00 PM Sister Arrived',
        ],
        'flowers' => [  
            'Blue Flower',
            'Yellow Flower',
            'Purple Flower',
        ],
        'equipments' => [  
            'Tent',
            'Carousel',
            'Cords',
        ],
        'point_of_contact' => [  
            'Contact 1',
            'Contact 2',
            'Contact 3',
        ],
        'attachments' => [  
            'Download Link 1',
            'Download Link 2',
            'Download Link 3',
        ],

    ];



    public array $positions = [];
 

    public $position_settings;

    public $display_value_font_size;



    /**  Display Settings */

        /** Card Settings */
            public $paddingLeft = 2;
            public $paddingRight = 2;
            public $paddingTop = 2;
            public $paddingBottom = 2;

            public $marginLeft = 2;
            public $marginRight = 2;
            public $marginTop = 2;
            public $marginBottom = 2;
        /** ./ Card Settings */


        /** Label and Text Display Settings */
            /** Label */
                public $labelSize = 16;
                public $labelLineHeight = 16;

                public $labelColor = '#000000';
                public $labelFontWeight = 'bold';
                public $labelFontStyle = 'normal';

                public $labelLetterSpacing = '0.5px';

            /** ./ Label */

            /** Text  */
                public $valueSize = 16;
                public $valueLineHeight = 16;

                public $valueColor = '#333333';
                public $valueFontWeight = 'normal';
                public $valueFontStyle = 'normal';
                public $valueLetterSpacing = '0.5px';

            /** ./ Text  */
            
        /** ./ Label and Text Display Settings */

 
    /** ./ Display Settings */

    public function mount( )
    {
 
        $this->display_value_font_size = 20;

        // $this->schedule = FuneralSchedule::first();
        // $schedule = $this->schedule;
        $setting = Setting::getPositionSetting();
        $jsonValue = json_decode($setting->value);

        // dd($jsonValue);

        $this->positions = $jsonValue ?? [
            'name_of_person',
            'date',
            'mass_time',
            'public_viewing',
            'family_viewing',
            'burial_cemetery',
            'burial_location',
            'hearse',
            'funeral_director',
            'co_funeral_director',
            'family_arrival',
            'flowers',
            'equipments',
            'point_of_contact',
            'attachments',
        ];


        // dd($this->positions);



        $this->getDisplaySettings();

    }


    public function refresh(){ 
        $setting = Setting::getPositionSetting();
        $jsonValue = json_decode($setting->value);
 

        $this->positions = $jsonValue ?? [
            'name_of_person',
            'date',
            'mass_time',
            'public_viewing',
            'family_viewing',
            'burial_cemetery',
            'burial_location',
            'hearse',
            'funeral_director',
            'co_funeral_director',
            'family_arrival',
            'flowers',
            'equipments',
            'point_of_contact',
            'attachments',
        ];
  

        $this->getDisplaySettings();

    }

    public function add( ){

        $this->display_value_font_size += 1;
    }

    // public function updatePosition($newOrder)
    // {
    //     $this->positions = collect($newOrder)->pluck('value')->toArray();
    // }

    public function updatePositions($data)
    {
        $this->positions = $data['order'];
    }

    public function addPosition($position)
    {
        $position = trim(strtolower(str_replace(' ', '_', $position)));

        if ($position && !in_array($position, $this->positions)) {
            $this->positions[] = $position;
        }
    }

    public function removePosition($position)
    {
        $this->positions = array_values(array_filter($this->positions, fn ($item) => $item !== $position));
    }


    public function getDisplaySettings(){

         
        $this->paddingLeft = Setting::getFontSetting('paddingLeft')->value ?? null;
        $this->paddingRight = Setting::getFontSetting('paddingRight')->value ?? null;
        $this->paddingTop = Setting::getFontSetting('paddingTop')->value ?? null;
        $this->paddingBottom = Setting::getFontSetting('paddingBottom')->value ?? null;

        $this->marginLeft = Setting::getFontSetting('marginLeft')->value ?? null;
        $this->marginRight = Setting::getFontSetting('marginRight')->value ?? null;
        $this->marginTop = Setting::getFontSetting('marginTop')->value ?? null;
        $this->marginBottom = Setting::getFontSetting('marginBottom')->value ?? null;

        $this->labelSize = Setting::getFontSetting('labelSize')->value ?? null;
        $this->labelLineHeight = Setting::getFontSetting('labelLineHeight')->value ?? null;
        $this->labelColor = Setting::getFontSetting('labelColor')->value ?? null;
        $this->labelFontWeight = Setting::getFontSetting('labelFontWeight')->value ?? null;
        $this->labelFontStyle = Setting::getFontSetting('labelFontStyle')->value ?? null;
        $this->labelLetterSpacing = Setting::getFontSetting('labelLetterSpacing')->value ?? null;

        $this->valueSize = Setting::getFontSetting('valueSize')->value ?? null;
        $this->valueLineHeight = Setting::getFontSetting('valueLineHeight')->value ?? null;
        $this->valueColor = Setting::getFontSetting('valueColor')->value ?? null;
        $this->valueFontWeight = Setting::getFontSetting('valueFontWeight')->value ?? null;
        $this->valueFontStyle = Setting::getFontSetting('valueFontStyle')->value ?? null;
        $this->valueLetterSpacing = Setting::getFontSetting('valueLetterSpacing')->value ?? null; 

    }


    public function save()
    {

        // dd($this->valueSize);
        // Ensure positions is not null and has at least one non-null value
        if (empty($this->positions) || !is_array($this->positions) || count(array_filter($this->positions)) === 0) {
            session()->flash('error', 'The positions array must contain at least one valid value.');
            return;
        }

        // Convert array to JSON
        $jsonValue = json_encode($this->positions);

        // dd($jsonValue);



        // // Save to settings 
        Setting::saveDisplaySettings([
            'paddingLeft'        => $this->paddingLeft,
            'paddingRight'       => $this->paddingRight,
            'paddingTop'         => $this->paddingTop,
            'paddingBottom'      => $this->paddingBottom,

            'marginLeft'         => $this->marginLeft,
            'marginRight'        => $this->marginRight,
            'marginTop'          => $this->marginTop,
            'marginBottom'       => $this->marginBottom,

            'labelSize'          => $this->labelSize,
            'labelLineHeight'    => $this->labelLineHeight,
            'labelColor'         => $this->labelColor,
            'labelFontWeight'    => $this->labelFontWeight,
            'labelFontStyle'     => $this->labelFontStyle,
            'labelLetterSpacing' => $this->labelLetterSpacing,

            'valueSize'          => $this->valueSize,
            'valueLineHeight'    => $this->valueLineHeight,
            'valueColor'         => $this->valueColor,
            'valueFontWeight'    => $this->valueFontWeight,
            'valueFontStyle'     => $this->valueFontStyle,
            'valueLetterSpacing' => $this->valueLetterSpacing,
        ]);





        $setting = Setting::getPositionSetting();
        $setting->value = $jsonValue;
        $setting->updated_by = Auth::user()->id;
        $setting->updated_at = now();
        $setting->save();
 
        // session()->flash('message', 'Position settings saved successfully.');

        try {
            event(new DashboardUpdated());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send DashboardUpdated event: ' . $e->getMessage(), [
                'user' => auth()->user()->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


        try {
            event(new PublicDashboardUpdated());
        } catch (\Throwable $e) {
            // Log the error without interrupting the flow
            Log::error('Failed to send PublicDashboardUpdated event: ' . $e->getMessage(), [
                'user' => auth()->user()->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }


        return redirect()->route('funeral_schedule.public.edit');
    }
    



    public function render()
    {
        return view('livewire.dashboard.admin-dashboard')
        ->layout('layouts.fullscreen')
        ;
    }
}
