<section class=" py-4 antialiased   ">
    <div wire:loading
        class="fixed inset-0     z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <div class="gap-4 sm:flex sm:items-center  overflow-auto ">
                <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl">Update Funeral Schedule Details</h2>
                  
                <div class="  flex items-center justify-end">

                    @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule show') )

                    <!-- show-funeral-schedule -->
                        <a href="{{ route('funeral_schedule.show',['funeral_schedule' => $funeral_schedule_id]) }}" 
                            wire:navigate
                            data-tooltip-target="tooltip-btn-show-funeral-schedule-{{ $funeral_schedule_id }}"
                            class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300  ">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                        </a>
                        <div id="tooltip-btn-show-funeral-schedule-{{ $funeral_schedule_id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip  ">
                            View Funeral Schedule Details
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    <!-- ./ show-funeral-schedule -->

                    @endif
                </div>
                
            </h2>


            </div>
            @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('hospice schedule show') )
            @if(!empty($hospice_schedule))
                 

                <div class="w-full border rounded-lg p-4 my-2">
                    <label for="flowers" class="block mb-1 text-sm font-medium text-gray-500 ">Hospice Schedule</label>

                    <a href="{{ route('hospice_schedule.show',['hospice_schedule' => $hospice_schedule->id]) }}"
                        wire:navigate
                        class="text-gray-900 text-md font-bold hover:underline hover:text-sky-500">
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


            <!-- Modal content -->
            <div class="relative  py-2  rounded-lg   ">
                 
                <!-- Modal body -->
                <form wire:submit="save">
                    <div class=" gap-4 mb-4 grid  ">
                        <div class="grid grid-cols-1 sm:grid-cols-2   gap-y-2 sm:gap-y-0 gap-x-2  ">

                            <div class="w-full {{ Auth::user()->hasRole('Global Administrator') ? 'col-span-2' : 'col-span-1' }}">
                                <label for="name_of_person" class="block mb-2 text-sm font-medium text-gray-900 ">Name of Person</label>
                                <input type="text" 
                                name="name_of_person" 
                                
                                wire:model.live="name_of_person"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit name')) == false ) 
                                    readonly 
                                @else    
                                    id="name_of_person" 
                                @endif
                                
                                >
                                <x-input-error :messages="$errors->get('name_of_person')" class="mt-2" />
                            </div>
                            @if(Auth::user()->hasRole('Global Administrator'))
                            <div class="w-full ">
                                <label for="folder" class="block my-2 text-sm font-medium text-gray-900 ">Folder</label>
                                <input type="text" 
                                name="folder" 
                                id="folder" 
                                wire:model="folder"
                                readonly
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 

                                > 
                                <x-input-error :messages="$errors->get('folder')" class="mt-2" /> <!-- folder is connected to name_of_person -->
                            </div>
                            @endif


                            <div class="w-full ">
                                <label for="date" class="block {{ Auth::user()->hasRole('Global Administrator') ? 'my-2' : 'mb-2' }}  text-sm font-medium text-gray-900 ">Date (MM DD YYYY)</label>
                                <input type="text" 
                                name="date" 
                                
                                wire:model="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit date')) == false )   
                                    readonly 
                                @else   
                                    id="date"  
                                @endif
                                >
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>


                            <div class="w-full ">
                                <label for="burial_cemetery" class="block my-2 text-sm font-medium text-gray-900 ">Burial Cemetery</label>
                                <input type="text" 
                                name="burial_cemetery" 
                                
                                wire:model="burial_cemetery"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit cemetery')) == false ) 
                                    readonly 
                                @else
                                    id="burial_cemetery" 
                                @endif
                                >
                                <x-input-error :messages="$errors->get('burial_cemetery')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="burial_location" class="block my-2 text-sm font-medium text-gray-900 ">Burial Location</label>
                                <input type="text" 
                                name="burial_location" 
                                
                                wire:model="burial_location"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit location')) == false ) 
                                    readonly 
                                @else    
                                    id="burial_location" 
                                @endif
                                >
                                <x-input-error :messages="$errors->get('burial_location')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="funeral_director" class="block my-2 text-sm font-medium text-gray-900 ">Funeral Director</label>
                                <input type="text" 
                                name="funeral_director" 
                                
                                wire:model="funeral_director"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit director')) == false )
                                    readonly 
                                @else 
                                    id="funeral_director" 
                                @endif
                                >
                                <x-input-error :messages="$errors->get('funeral_director')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="co_funeral_director" class="block my-2 text-sm font-medium text-gray-900 ">Funeral Co-Director</label>
                                <input type="text" 
                                name="co_funeral_director" 
                                
                                wire:model="co_funeral_director"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit co director')) == false ) 
                                    readonly 
                                @else
                                    id="co_funeral_director" 
                                @endif
                                >
                                <x-input-error :messages="$errors->get('co_funeral_director')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="hearse" class="block my-2 text-sm font-medium text-gray-900 ">Hearse</label>
                                <input type="text" 
                                name="hearse" 
                                
                                wire:model="hearse"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit hearse')) == false ) 
                                    readonly 
                                @else    
                                    id="hearse" 
                                @endif
                                >
                                <x-input-error :messages="$errors->get('hearse')" class="mt-2" />
                            </div>


                            <div class="w-full ">
                                <label for="mass_time" class="block my-2 text-sm font-medium text-gray-900 ">Mass Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="mass_time" 
                                
                                wire:model="mass_time"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit mass time')) == false ) 
                                    readonly 
                                @else    
                                    id="mass_time" 
                                @endif
                                >
                                <x-input-error :messages="$errors->get('mass_time')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="public_viewing_start" class="block my-2 text-sm font-medium text-gray-900 ">Public Viewing Start Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="public_viewing_start" 
                                
                                wire:model="public_viewing_start"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit public time')) == false ) 
                                    readonly
                                @else
                                    id="public_viewing_start" 
                                @endif
                                >
                                <x-input-error :messages="$errors->get('public_viewing_start')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="public_viewing_end" class="block my-2 text-sm font-medium text-gray-900 ">Public Viewing End Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="public_viewing_end" 
                                
                                wire:model="public_viewing_end"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit public time')) == false )
                                    readonly 
                                @else
                                    id="public_viewing_end" 
                                @endif
                                >
                                <x-input-error :messages="$errors->get('public_viewing_end')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="family_viewing_start" class="block my-2 text-sm font-medium text-gray-900 ">Family Viewing Start Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="family_viewing_start" 
                                
                                wire:model="family_viewing_start"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit family time')) == false ) 
                                    readonly 
                                @else 
                                    id="family_viewing_start" 
                                @endif
                                >
                                <x-input-error :messages="$errors->get('family_viewing_start')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="family_viewing_end" class="block my-2 text-sm font-medium text-gray-900 ">Family Viewing End Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="family_viewing_end" 
                                @if((Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit family time')) == false ) 
                                    readonly 
                                @else
                                    id="family_viewing_end" 
                                @endif

                                
                                wire:model="family_viewing_end"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 "  
                                >
                                <x-input-error :messages="$errors->get('family_viewing_end')" class="mt-2" />
                            </div>


                             
                        </div>
                        
                        @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule view family arrival') )
                        <!-- Family Arrivals-->
                        <div class="w-full border rounded-lg p-4">
                            <label for="family_arrival" class="block my-2 text-sm font-medium text-gray-900 ">Family Arrival</label>
                            
                            <x-input-error :messages="$errors->get('family_arrival')" class="mt-2" />
                           
                            <div class="grid grid-cols-1  gap-y-2 sm:gap-y-0 gap-x-2  "  >


                                
                                
                                @foreach ($familyArrivals as $index => $arrival)
                                    <div class="grid grid-cols-1 sm:grid-cols-8  gap-2 mb-2">
                                        <div class=" sm:col-span-1">
                                            {{-- <div>{{ $familyArrivals[$index]['time'] ?? 'NO TIME' }}</div> --}}

                                            <input 
                                                type="time" 
                                                wire:model.defer="familyArrivals.{{ $index }}.time" 
                                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" 
                                                data-index="{{ $index }}" 
                                                placeholder="Select Time"
                                            >
                                        </div>
                                        
                                        <div class=" sm:col-span-7 sm:flex gap-2">
                                            <input 
                                            type="text" 
                                            wire:model.defer="familyArrivals.{{ $index }}.notes" 
                                            placeholder="Notes" 
                                            class="input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            >

                                            <button type="button"
                                            class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  "
                                            wire:click="removeFamilyArrival({{ $index }})">
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                            </button>
                                        </div>
                                        
                                    </div>
                                @endforeach 

                                <button 
                                class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300  focus:outline-none "
                                type="button"
                                 wire:click="addFamilyArrival">
                                    + Add Family Arrival
                                </button>

                            </div>
                        </div>
                        <!-- ./ Family Arrivals-->
                        @endif

                         @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('uneral schedule view flowers') )
                        <!-- Flower -->
                        <div class="w-full border rounded-lg p-4">
                            <label for="flowers" class="block my-2 text-sm font-medium text-gray-900 ">Flowers</label>
                            
                            <x-input-error :messages="$errors->get('flowers')" class="mt-2" />
                           
                            <div class="grid grid-cols-1  gap-y-2 sm:gap-y-0 gap-x-2  "  >


                                

                                @foreach ($flowers as $index => $flower)
                                    <div class="grid grid-cols-1 sm:grid-cols-8  gap-2 mb-2">
                                        <div class=" sm:col-span-4">
                                            <input 
                                                type="text" 
                                                wire:model.defer="flowers.{{ $index }}.name" 
                                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" 
                                                data-index="{{ $index }}" 
                                                placeholder="Flower"
                                            >
                                        </div>
                                        
                                        <div class=" sm:col-span-4 sm:flex gap-2">
                                            <input 
                                            type="text" 
                                            wire:model.defer="flowers.{{ $index }}.notes" 
                                            placeholder="Notes" 
                                            class="input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            >

                                            <button type="button"
                                            class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  "
                                            wire:click="removeflower({{ $index }})">
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                            </button>
                                        </div>
                                        
                                    </div>
                                @endforeach

                                <button 
                                class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300  focus:outline-none "
                                type="button"
                                wire:click="addflower">
                                    + Add Flower
                                </button>

                            </div>
                        </div> 
                        <!-- ./ Flower -->
                        @endif

                         @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule view equipments') )
                         <!-- Equipments -->
                        <div class="w-full border rounded-lg p-4">
                            <label for="equipments" class="block my-2 text-sm font-medium text-gray-900 ">Equipments</label>
                            
                            <x-input-error :messages="$errors->get('equipments')" class="mt-2" />
                           
                            <div class="grid grid-cols-1  gap-y-2 sm:gap-y-0 gap-x-2  "  >


                                

                                @foreach ($equipments as $index => $equipment)
                                    <div class="grid grid-cols-1 sm:grid-cols-8  gap-2 mb-2">
                                        <div class=" sm:col-span-4">
                                            <input 
                                                type="text" 
                                                wire:model.defer="equipments.{{ $index }}.name" 
                                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" 
                                                data-index="{{ $index }}" 
                                                placeholder="Equipment"
                                            >
                                        </div>
                                        
                                        <div class=" sm:col-span-4 sm:flex gap-2">
                                            <input 
                                            type="text" 
                                            wire:model.defer="equipments.{{ $index }}.notes" 
                                            placeholder="Notes" 
                                            class="input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            >

                                            <button type="button"
                                            class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  "
                                            wire:click="removeEquipment({{ $index }})">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                            
                                            </button>
                                        </div>
                                        
                                    </div>
                                @endforeach

                                <button 
                                class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300  focus:outline-none "
                                type="button"
                                wire:click="addEquipment">
                                    + Add Equipment
                                </button>

                            </div>
                        </div> 
                        <!-- ./ Equipments -->
                        @endif

                        <!-- Point of Contact -->
                        <div class="w-full border rounded-lg p-4">
                            <label for="familyPointOfContact" class="block my-2 text-sm font-medium text-gray-900 ">Family Point of Contacts</label>
                            
                            <x-input-error :messages="$errors->get('familyPointOfContact')" class="mt-2" />
                           
                            <div class="grid grid-cols-1  gap-y-2 sm:gap-y-0 gap-x-2  "  >


                                

                                @foreach ($familyPointOfContact as $index => $equipment)
                                    <div class="grid grid-cols-1 sm:grid-cols-8  gap-2 mb-2">
                                        <div class=" sm:col-span-4">
                                            <input 
                                                type="text" 
                                                wire:model.defer="familyPointOfContact.{{ $index }}.phone" 
                                                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" 
                                                data-index="{{ $index }}" 
                                                placeholder="Phone/Email"
                                            >
                                        </div>
                                        
                                        <div class=" sm:col-span-4 sm:flex gap-2">
                                            <input 
                                            type="text" 
                                            wire:model.defer="familyPointOfContact.{{ $index }}.notes" 
                                            placeholder="Notes" 
                                            class="input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                            >

                                            <button type="button"
                                            class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  "
                                            wire:click="removeFamilyPointOfContact({{ $index }})">
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                            
                                            </button>
                                        </div>
                                        
                                    </div>
                                @endforeach

                                <button 
                                class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300  focus:outline-none "
                                type="button"
                                wire:click="addFamilyPointOfContact">
                                    + Add Contact
                                </button>

                            </div>
                        </div> 
                        <!-- ./ Point of Contact -->




                         @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule add attachments') )
                        <!-- Attachments --> 
                        <div class="w-full border rounded-lg p-4">
                            <label for="attachments" class="block my-2 text-sm font-medium text-gray-900 ">Funeral Attachments </label>
                             
                            <livewire:dropzone
                            wire:model="attachments"
                            :rules="['file', 'mimes:png,jpeg,jpg,pdf,docx,xlsx,csv,txt,zip', 'max:20480']"
                            :multiple="true" />


                            @error('attachments')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror 
                        </div>
                        <!-- ./ Attachments -->
                        @endif



                        <!-- Existing Attachments -->
                        <div class="w-full border rounded-lg p-4">
                            @php
                                function isImageMime($filename) {
                                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                                    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                    return in_array($extension, $imageExtensions);
                                }
                            @endphp
                            

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
                                                        <?php 
                                                        // $attachment_file = asset('storage/uploads/funeral_attachments/' . $attachment['attachment']);
                                                        $attachment_file = route('ftp.download', ['id' => $attachment['id']]); 
                                                        ?>



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
                                
                                                            <div class="dz-flex dz-items-center dz-mr-3 dz-gap-1">
                                                                {{-- <a 
                                                                    href="{{ asset('storage/uploads/funeral_attachments/' . $attachment['attachment']) }}" 
                                                                    download="{{ $attachment['attachment'] }}" 
                                                                    class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                                                    
                                                                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <path fill="#ffffff" d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                                                    </svg>
                                                                </a> --}}
                                                                @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule download attachments') )
                                                                <a 
                                                                    href="{{ route('ftp.download', ['id' => $attachment['id']]) }}" 
                                                                    class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                                                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <path fill="#ffffff" d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                                                    </svg>
                                                                </a>
                                                                @endif

                                                                @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule delete attachments') )
                                                                
                                                                <div class="dz-flex dz-flex-col dz-items-start dz-gap-1">
                                                                    <div class="dz-text-center dz-text-slate-900 dz-text-sm dz-font-medium">
                                                                        <button type="button"
                                                                        class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  "
                                                                        wire:click="removeAttachment('{{ $date }}', {{ $attachment['id'] }})"
                                                                        >
                                                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                @endif

                                                            </div>

                                                            

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


                    </div>
                    <button 
                    type="button" 
                    wire:click="save"
                    wire:confirm="Are you sure?"
                    class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Save
                    </button>
                    <a href="{{ route('funeral_schedule.index') }}" 
                        wire:navigate
                        class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Cancel
                    </a>
                </form>
            </div> 
        </div> 
    </div>


    @push('scripts')
        <script>
          

            $(document).ready(function() {
                flatpickr("#date", {    
                    noCalendar: false,
                    dateFormat: "m d Y", // <- safer format for saving in DB
                    onChange: function(selectedDates, dateStr, instance) {
                        @this.set('date', dateStr);
                    }
                });
            });


            $(document).ready(function() {
                flatpickr("#mass_time", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K",

                    minuteIncrement: 30,
                    onChange: function(selectedDates, dateStr, instance) {
                        @this.set('mass_time', dateStr);
                    }
                });
            });

            $(document).ready(function() {
                flatpickr("#public_viewing_start", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K",

                    minuteIncrement: 30,
                    onChange: function(selectedDates, dateStr, instance) {
                        @this.set('public_viewing_start', dateStr);
                    }
                });
            });

            $(document).ready(function() {
                flatpickr("#public_viewing_end", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K",

                    minuteIncrement: 30,
                    onChange: function(selectedDates, dateStr, instance) {
                        @this.set('public_viewing_end', dateStr);
                    }
                });
            });

            $(document).ready(function() {
                flatpickr("#family_viewing_start", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K",

                    minuteIncrement: 30,
                    onChange: function(selectedDates, dateStr, instance) {
                        @this.set('family_viewing_start', dateStr);
                    }
                });
            });

            $(document).ready(function() {
                flatpickr("#family_viewing_end", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K",

                    minuteIncrement: 30,
                    onChange: function(selectedDates, dateStr, instance) {
                        @this.set('family_viewing_end', dateStr);
                    }
                });
            });



        </script>

@endpush

</section>
