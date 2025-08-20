<section class=" py-4 antialiased   "
    x-data="{ 
        positions: @entangle('positions'),
        options:  @entangle('options'),
        addItem(key) {
            const index = this.positions.indexOf(key);
            if (index !== -1) this.positions.splice(index, 1); // Remove existing
            this.positions.push(key); // Add to end
        }
    
    
    }",


>
    {{-- <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div> --}}

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl  flex align-middle space-x-4"> 

                 
                @if(Auth::check())
                    <a class="hover:text-blue-500" href="{{ route('funeral_schedule.show',['funeral_schedule' => $funeral_schedule_id]) }}" target="_blank">
                        {{ $name_of_person }}
                    </a> 
                    <a class="hover:text-blue-500" href="{{ route('funeral_schedule.public.show',['funeral_schedule' => $funeral_schedule_id]) }}" target="_blank">
                        <svg class="shrink-0 w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 lg:w-8 lg:h-8"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#000000" d="M32 32C14.3 32 0 46.3 0 64l0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L32 32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7 14.3 32 32 32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0 0-64zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0 0 64c0 17.7 14.3 32 32 32s32-14.3 32-32l0-96c0-17.7-14.3-32-32-32l-96 0zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 64-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l96 0c17.7 0 32-14.3 32-32l0-96z"/></svg>
                    </a>


                    @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit') )
                    <div class="  flex items-center justify-end">
                        <!-- edit-funeral-schedule -->
                            <a href="{{ route('funeral_schedule.edit',['funeral_schedule' => $funeral_schedule_id]) }}" 
                                data-tooltip-target="tooltip-btn-edit-funeral-schedule-{{ $funeral_schedule_id }}"
                                class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  ">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>
                            </a>
                            <div id="tooltip-btn-edit-funeral-schedule-{{ $funeral_schedule_id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip  ">
                                Update Funeral Schedule
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        <!-- ./ edit-funeral-schedule -->
                    </div>
                    @endif
                @else
                    <a class="hover:text-blue-500" href="{{ route('funeral_schedule.show',['funeral_schedule' => $funeral_schedule_id]) }}" target="_blank">
                        {{ $name_of_person }}
                    </a>
                    <a class="hover:text-blue-500" href="{{ route('funeral_schedule.public.show',['funeral_schedule' => $funeral_schedule_id]) }}" target="_blank">
                        <svg class="shrink-0 w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 lg:w-8 lg:h-8"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#000000" d="M32 32C14.3 32 0 46.3 0 64l0 96c0 17.7 14.3 32 32 32s32-14.3 32-32l0-64 64 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L32 32zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7 14.3 32 32 32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-64 0 0-64zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0 0 64c0 17.7 14.3 32 32 32s32-14.3 32-32l0-96c0-17.7-14.3-32-32-32l-96 0zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 64-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l96 0c17.7 0 32-14.3 32-32l0-96z"/></svg>
                    </a>
                @endif
                
            </h2>
            <p class="text-sm text-gray-500 mb-2">Funeral Schedule Details</p>
            <p class="text-sm text-gray-500 mb-2">Last updated {{ $updated_at->diffForHumans() }}</p>
            
            @if(Auth::check())
            @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('hospice schedule show') )
            @if(!empty($hospice_schedule))
                 

                <div class="w-full border rounded-lg p-4 mb-2">
                    <label for="flowers" class="block mb-1 text-sm font-medium text-gray-500 ">Hospice Schedule</label>

                    <a href="{{ route('hospice_schedule.show',['hospice_schedule' => $hospice_schedule->id]) }}" class="text-gray-900 text-md font-bold hover:underline hover:text-sky-500">
                        {{ $hospice_schedule->name }}
                    </a>
                    <p class="text-gray-700 text-sm"> 
                        {{ $hospice_schedule->start_date ? $hospice_schedule->start_date->format('M d Y') : '' }} to   
                        {{ $hospice_schedule->end_date ? $hospice_schedule->end_date->format('M d Y') : '' }} 
                    </p>
                </div> 
                
 
            @endif
            <!-- ./ Hospice Schedule -->
            @endif
            @endif

            <div class="mx-auto max-w-6xl space-y-6">
                
 
                <div class="mx-auto max-w-6xl space-y-6">


                <div 
                    x-data="{ 
                        positions: @entangle('positions'),
                        options:  @entangle('options'),
                        addItem(key) {
                            const index = this.positions.indexOf(key);
                            if (index !== -1) this.positions.splice(index, 1); // Remove existing
                            this.positions.push(key); // Add to end
                        }
                    
                    
                    }",
                    
                    class="flex gap-4"
                >
                    <!-- Sidebar 
                    <div class="w-48 bg-gray-100 p-4 rounded shadow">
                        <h2 class="text-sm font-semibold mb-2 flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i>
                            Add Fields
                        </h2>
                        <template x-for="opt in options" :key="opt">
                            <button 
                                class=" w-full mb-2 px-2 py-1 text-left text-sm bg-white rounded hover:bg-blue-100 flex items-center"
                                @click="addItem(opt)"
                            >
                        
                    

    

                    <!-- drawer component -->
                    <div id="fields-drawer" class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-label">
                        <h5 id="drawer-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 me-2.5  " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>Add Fields
                        </h5>

                        

                        <button type="button" data-drawer-hide="fields-drawer" aria-controls="fields-drawer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
                            <svg class="w-3 h-3 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close menu</span>
                        </button>
                            
                        <p class="max-w-lg mb-6 text-sm text-gray-500 dark:text-gray-400">
                            ✅ Means that the field is already added to the display
                        </p>



                        <template x-for="opt in options" :key="opt" class="grid grid-cols-1 ">
                            <button 
                                class="block w-full mb-2 px-4 py-2 text-sm font-medium text-start text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 "
                                @click="addItem(opt)"
                            >
                                <i class="fas fa-plus mr-2 "></i>
                                <span x-text="opt.replaceAll('_', ' ').replace(/\b\w/g, l => l.toUpperCase())"></span>

                                <!-- Checkmark if already added -->
                                <span 
                                    class=" "
                                    x-show="positions.includes(opt)"
                                >
                                    ✅
                                </span>

                            </button>
                        </template>

                    </div>



                    <!-- Main Display Area -->
                    <div class="flex-1 space-y-2">
                        <template x-for="(item, index) in positions" :key="index">
                            <div 
                                class="p-4 odd:bg-white even:bg-gray-50 border-gray-200  rounded shadow flex justify-between items-center text-sm  text-gray-500 "
                                 
                            >
                                {{-- <span x-text="item.replaceAll('_', ' ').replace(/\b\w/g, l => l.toUpperCase())"></span> --}}

                                <span>
                                    <span class="font-medium text-gray-900 whitespace-nowrap " x-text="item.replaceAll('_', ' ').replace(/\b\w/g, l => l.toUpperCase())"></span>: 
                                    
                                </span>

                                <span class="flex gap-4">  

                                    <!--
                                        <template x-if="Array.isArray($wire.data[item])">
                                            <div class=" block text-sm   text-end">
                                                <template x-for="line in $wire.data[item]" :key="line">
                                                    <div x-text="line"></div>
                                                </template>
                                            </div>
                                        </template>
                                    -->
                                    {{--  
                                    <!-- Array Handling -->
                                    <template x-if="Array.isArray($wire.data[item])">
                                        <div class="space-y-1 ">
                                            <template x-for="(entry, i) in $wire.data[item]" :key="i">
                                                <div class="grid">
                                                    <!-- family_arrival: time + notes -->
                                                    <template x-if="entry && entry.time && entry.notes">
                                                        <div class="space-x-1">
                                                            <span class="font-semibold text-gray-800" x-text="`${entry.time}:`"></span>
                                                            <span class="italic text-gray-600" x-text="entry.notes"></span>
                                                        </div>
                                                    </template>

                                                    <!-- flowers or equipments: name + notes -->
                                                    <template x-if="entry && entry.name && entry.notes"> 
                                                        <div class="space-x-1">
                                                            <span class="font-semibold text-gray-800" x-text="`${entry.name} - `"></span>
                                                            <span class="italic text-gray-600" x-text="entry.notes"></span>
                                                        </div>
                                                    </template>


                                                    <template x-if="$wire.data.attachments && Object.keys($wire.data.attachments).length">
                                                        <div class="space-y-4">
                                                            <template x-for="[date, files] of Object.entries($wire.data.attachments)" :key="date">
                                                            <div class="border p-2 rounded shadow-sm bg-gray-50">
                                                                <div class="font-semibold text-gray-800 mb-2" x-text="date"></div>

                                                                <ul class="list-disc list-inside text-sm text-gray-700">
                                                                <template x-for="file in files" :key="file.id">
                                                                    <li>
                                                                    <a 
                                                                        class="text-blue-600 hover:underline" 
                                                                        target="_blank" 
                                                                        :href="'/storage/attachments/' + file.attachment"
                                                                        x-text="file.attachment"
                                                                    ></a>
                                                                    </li>
                                                                </template>
                                                                </ul>
                                                            </div>
                                                            </template>
                                                        </div>
                                                    </template>



                                                    <!-- fallback: show name or string -->
                                                    <template x-if="entry && typeof entry === 'object' && !entry.notes && entry.name">
                                                        <div x-text="entry.name"></div>
                                                    </template>

                                                    <!-- fallback primitive -->
                                                    <template x-if="typeof entry !== 'object'">
                                                        <div x-text="entry"></div>
                                                    </template>


                                                    


                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    --}}

                                    <!-- Array Handling -->
                                    <template x-if="Array.isArray($wire.data[item])">
                                        <div class="grid  ">
                                            

                                           

                                            <!-- Attachments Handling -->
                                           <template x-if="item === 'attachments'" class="text-end w-full">
                                                
                                                <div class="flex justify-end space-y-1 space-x-1">

                                                
                                                    @auth     
                                                    <div   class="  max-w-[50%] overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="attachment">
                                                        
                                                        <div class="dz-flex dz-flex-wrap dz-gap-x-10 dz-gap-y-2 dz-justify-start dz-w-full"> 
                                                            <template x-for="(file, i) in $wire.data[item]" :key="i">

                                                                <div class="dz-flex dz-items-center dz-justify-between dz-gap-2 dz-border dz-rounded dz-border-gray-200 dz-w-full">
                                                                    <div class="dz-flex dz-items-center dz-gap-3">
                                                                        
                                                                        <div class="dz-flex dz-justify-center dz-items-center dz-w-14 dz-h-14 dz-bg-gray-100 ">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="dz-w-8 dz-h-8 dz-text-gray-500">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                                            </svg>
                                                                        </div> 
                                                                        <div class="dz-flex dz-flex-col dz-items-start dz-gap-1">
                                                                            <div class="dz-text-center dz-text-slate-900 dz-text-sm dz-font-medium">
                                                                                <span class="italic text-gray-600" x-text="file.attachment"></span>  
                                                                            </div>
                                                                        </div>

                                                                        
                                                                    </div>
                                                                    
                                                                    <div class="dz-flex dz-items-center dz-mr-3 dz-gap-1">
                                                                        <a 
                                                                            :href="file.attachment_file" 
                                                                            :download="file.attachment" 
                                                                            {{-- x-text="file.attachment" --}}
                                                                            class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                                                            
                                                                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                                <path fill="#ffffff" d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                                                            </svg>
                                                                        </a>


                                                                        

                                                                    </div> 
                                                                    

                                                                </div> 
                                                            </template> 
                                                        </div>
                                                    </div>
                                                    @endauth

                                                    @guest
                                                        <div   class="  max-w-[50%] overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="attachment">
                                                        
                                                            <div class="dz-flex dz-flex-wrap dz-gap-x-10 dz-gap-y-2 dz-justify-start dz-w-full"> 
                                                                <template x-for="(file, i) in $wire.data[item]" :key="i">

                                                                    <div class="dz-flex dz-items-center dz-justify-between dz-gap-2 dz-border dz-rounded dz-border-gray-200 dz-w-full">
                                                                        <div class="dz-flex dz-items-center dz-gap-3">
                                                                            
                                                                            <div class="dz-flex dz-justify-center dz-items-center dz-w-14 dz-h-14 dz-bg-gray-100 ">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="dz-w-8 dz-h-8 dz-text-gray-500">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                                                </svg>
                                                                            </div> 
                                                                            <div class="dz-flex dz-flex-col dz-items-start dz-gap-1">
                                                                                <div class="dz-text-center dz-text-slate-900 dz-text-sm dz-font-medium">
                                                                                    <span class="italic text-gray-600" x-text="file.attachment"></span>  
                                                                                </div>
                                                                            </div>

                                                                            
                                                                        </div>
                                                                        
                                                                        <div class="dz-flex dz-items-center dz-mr-3 dz-gap-1">
                                                                            <a 
                                                                                href="{{ route('login') }}"  
                                                                                {{-- x-text="file.attachment" --}}
                                                                                class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                                                                
                                                                                <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                                    <path fill="#ffffff" d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                                                                </svg>
                                                                            </a>


                                                                            

                                                                        </div> 
                                                                        

                                                                    </div> 
                                                                </template> 
                                                            </div>
                                                        </div>

                                                    @endguest
                                                
                                                </div>  

                                            </template>



                                            <template x-if="item !== 'attachments'">
                                                <template x-for="(entry, i) in $wire.data[item]" :key="i">
                                                    <div class="grid text-end">
                                                        <!-- family_arrival: time + notes -->
                                                        <template x-if="entry && entry.time && entry.notes">
                                                            <div class="space-x-1">
                                                                <span class="font-semibold text-gray-800" x-text="entry.time + ':'"></span>
                                                                <span class="italic text-gray-600" x-text="entry.notes"></span>
                                                            </div>
                                                        </template>

                                                        <!-- flowers or equipments: name + notes -->
                                                        <template x-if="entry && entry.name && entry.notes"> 
                                                            <div class="space-x-1">
                                                                <span class="font-semibold text-gray-800" x-text="entry.name + ' - '"></span>
                                                                <span class="italic text-gray-600" x-text="entry.notes"></span>
                                                            </div>
                                                        </template>

                                                        <!-- flowers or family point of contact: name + notes -->
                                                        <template x-if="entry && entry.phone && entry.notes"> 
                                                            <div class="space-x-1">
                                                                <span class="font-semibold text-gray-800" x-text="entry.phone + ' - '"></span>
                                                                <span class="italic text-gray-600" x-text="entry.notes"></span>
                                                            </div>
                                                        </template>

                                                        <!-- fallback: show name or string -->
                                                        <template x-if="entry && typeof entry === 'object' && !entry.notes && entry.name">
                                                            <div x-text="entry.name"></div>
                                                        </template>

                                                        <!-- fallback primitive -->
                                                        <template x-if="typeof entry !== 'object'">
                                                            <div x-text="entry"></div>
                                                        </template>
                                                    </div>
                                                </template>
                                            </template>
                                        </div>
                                    </template>







                                    <template x-if="!Array.isArray($wire.data[item])"> 
                                        <span class="text-end" x-text="$wire.data[item] ?? '—'"></span>
                                        

                                        {{-- <div class="space-x-1">
                                            <span class="font-semibold text-gray-800" x-text="entry.time + ':'"></span>
                                            <span class="italic text-gray-600" x-text="entry.notes"></span>
                                        </div> --}}

                                    </template>
                                     

                                </span>
                                
                            </div>


                            {{-- <template x-if="Array.isArray($wire.data[item])">
                                <div class="whitespace-pre-line text-sm text-gray-700">
                                    <template x-for="line in $wire.data[item]" :key="line">
                                        <div x-text="line"></div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!Array.isArray($wire.data[item])">
                                <span x-text="$wire.data[item] ?? '—'"></span>
                            </template> --}}


                        </template>

                         
                    </div>

                </div>

 
 



            </div>
                


                {{-- 
                @if(Auth::check())
                @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule view family arrival') )
                @if(!empty($familyArrivals) && count($familyArrivals))
                    <div class="mb-2">
                         
                            <p class="text-base font-semibold text-gray-900  mb-2">Family Arrival:</p>
                            <ul class="list-outside list-disc space-y-4 pl-4 text-base font-normal text-gray-500 ">

                                @foreach ($familyArrivals as $arrival)
                                    <li>
                                        <span class="font-semibold text-gray-900 "> {{ $arrival['time'] }}: </span>
                                        {{ $arrival['notes'] }}
                                    </li>
                                @endforeach
                                 
                            </ul> 
                    </div>
                @endif
                @endif
                @endif
                    

                @if(Auth::check())
                @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule view flowers') )
                @if(!empty($flowers) && count($flowers))
                    <div class="mb-2">
                         
                            <p class="text-base font-semibold text-gray-900  mb-2">Flowers:</p>
                            <ul class="list-outside list-disc space-y-4 pl-4 text-base font-normal text-gray-500 ">

                                @foreach ($flowers as $flower)
                                    <li>
                                        <span class="font-semibold text-gray-900 "> {{ $flower['name'] }}: </span>
                                        {{ $flower['notes'] }}
                                    </li>
                                @endforeach
                                 
                            </ul>
                         
                    </div>
                @endif
                @endif
                @endif

                 @if(Auth::check())
                @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule view equipments') )
                @if(!empty($equipments) && count($equipments))
                    <div class="mb-2">
                         
                            <p class="text-base font-semibold text-gray-900  mb-2">Equipments:</p>
                            <ul class="list-outside list-disc space-y-4 pl-4 text-base font-normal text-gray-500 ">

                                @foreach ($equipments as $equipment)
                                    <li>
                                        <span class="font-semibold text-gray-900 "> {{ $equipment['name'] }}: </span>
                                        {{ $equipment['notes'] }}
                                    </li>
                                @endforeach
                                 
                            </ul>
                         
                    </div>
                @endif
                @endif
                @endif


                @php
                    if (!function_exists('isImageMime')) {
                        function isImageMime($filename) {
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                            return in_array($extension, $imageExtensions);
                        }
                    }
                @endphp


                @if(Auth::check())
                @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule view attachments') )
                @if(isset($existingFiles) && count($existingFiles) > 0)
                <!-- Existing Attachments -->
                    <div class="w-full border rounded-lg p-4">
                       
                        

                        @if(isset($existingFiles) && count($existingFiles) > 0)
                            @php
                                $index = 1;
                            @endphp

                            @foreach($existingFiles as $date => $project_documents)
                                <div class="">
                                    <div class="" id="attachment-{{ $index }}">
                                        <div type="button" class=" 
                                                py-3 inline-flex items-center gap-x-3 w-full font-semibold text-start text-gray-800 hover:text-gray-500 focus:outline-none focus:text-gray-500 rounded-lg "
                                            aria-expanded="false" aria-controls="hs-basic-collapse-{{ $index }}">
                                
                                            {{ $date }}
                                        </div>
                            
                                        <div id="hs-basic-collapse-{{ $index }}" class="
                                            w-full overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="attachment-{{ $index }}">
                                            
                                            <div class="dz-flex dz-flex-wrap dz-gap-x-10 dz-gap-y-2 dz-justify-start dz-w-full">
                                                @foreach ($project_documents as $attachment)
                                                    <?php $attachment_file = asset('storage/uploads/funeral_attachments/' . $attachment['attachment']); ?>



                                                    <div class="dz-flex dz-items-center dz-justify-between dz-gap-2 dz-border dz-rounded dz-border-gray-200 dz-w-full">
                                                        <div class="dz-flex dz-items-center dz-gap-3">
                                                            @if(isImageMime($attachment_file))
                                                                <div class="dz-flex-none dz-w-14 dz-h-14">
                                                                    <img src="{{ $attachment_file }}" class="dz-object-fill dz-w-full dz-h-full" alt="{{ $attachment_file }}">
                                                                </div>
                                                            @else
                                                                <div class="dz-flex dz-justify-center dz-items-center dz-w-14 dz-h-14 dz-bg-gray-100 ">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="dz-w-8 dz-h-8 dz-text-gray-500">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                                    </svg>
                                                                </div>
                                                            @endif
                                                            <div class="dz-flex dz-flex-col dz-items-start dz-gap-1">
                                                                <div class="dz-text-center dz-text-slate-900 dz-text-sm dz-font-medium">{{ $attachment['attachment'] }}</div>
                                                            </div>

                                                            
                                                        </div>
                                                        
                                                        @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule download attachments') )
                                                        <div class="dz-flex dz-items-center dz-mr-3 dz-gap-1">
                                                            <a 
                                                                href="{{ asset('storage/uploads/funeral_attachments/' . $attachment['attachment']) }}" 
                                                                download="{{ $attachment['attachment'] }}" 
                                                                class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                                                
                                                                <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                    <path fill="#ffffff" d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                                                </svg>
                                                            </a>


                                                             

                                                        </div>
                                                        @endif
                                                        

                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php($index++)
                            @endforeach
                    


                        @endif
                    </div>
                <!-- ./ Existing Attachments -->
                @endif
                @endif
                @endif
                     --}}


            </div>

            
            
             
        </div>
    </div>
</section>