<section class=" py-4 antialiased   ">
    {{-- <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div> --}}
    <div wire:loading
        class="fixed inset-0     z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <div class="gap-4 sm:flex sm:items-center sm:justify-between overflow-auto ">
                <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl">Create Funeral Schedule</h2>
            </div>

            <!-- Hospice Schedule -->

            @if(!empty($hospice_schedule))
                 

                <div class="w-full border rounded-lg p-4 mb-2">
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

            <!-- Modal content -->
            <div class="relative  py-2  rounded-lg   ">
                 
                <!-- Modal body -->
                <form wire:submit="save">
                    <div class=" gap-4 mb-4 grid  ">
                        <div class="grid grid-cols-1 sm:grid-cols-2   gap-y-2 sm:gap-y-0 gap-x-2  ">
                            


                            <div class="w-full {{ Auth::user()->hasRole('Global Administrator') ? 'col-span-2' : 'col-span-1' }} ">
                                <label for="name_of_person" class="block my-2 text-sm font-medium text-gray-900 ">Name of Person</label>
                                <input type="text" 
                                name="name_of_person" 
                                id="name_of_person" 
                                wire:model.live="name_of_person"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
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
                                <label for="date" class="block {{ Auth::user()->hasRole('Global Administrator') ? 'my-2' : 'my-2' }} text-sm font-medium text-gray-900 ">Date (MM DD YYYY)</label>
                                <input type="text" 
                                name="date" 
                                id="date" 
                                wire:model="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            </div>
                             
                            <div class="w-full ">
                                <label for="burial_cemetery" class="block my-2 text-sm font-medium text-gray-900 ">Burial Cemetery</label>
                                <input type="text" 
                                name="burial_cemetery" 
                                id="burial_cemetery" 
                                wire:model="burial_cemetery"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('burial_cemetery')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="burial_location" class="block my-2 text-sm font-medium text-gray-900 ">Burial Location</label>
                                <input type="text" 
                                name="burial_location" 
                                id="burial_location" 
                                wire:model="burial_location"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('burial_location')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="funeral_director" class="block my-2 text-sm font-medium text-gray-900 ">Funeral Director</label>
                                <input type="text" 
                                name="funeral_director" 
                                id="funeral_director" 
                                wire:model="funeral_director"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('funeral_director')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="co_funeral_director" class="block my-2 text-sm font-medium text-gray-900 ">Funeral Co-Director</label>
                                <input type="text" 
                                name="co_funeral_director" 
                                id="co_funeral_director" 
                                wire:model="co_funeral_director"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('co_funeral_director')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="hearse" class="block my-2 text-sm font-medium text-gray-900 ">Hearse</label>
                                <input type="text" 
                                name="hearse" 
                                id="hearse" 
                                wire:model="hearse"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('hearse')" class="mt-2" />
                            </div>


                            <div class="w-full ">
                                <label for="mass_time" class="block my-2 text-sm font-medium text-gray-900 ">Mass Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="mass_time" 
                                id="mass_time" 
                                wire:model="mass_time"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('mass_time')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="public_viewing_start" class="block my-2 text-sm font-medium text-gray-900 ">Public Viewing Start Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="public_viewing_start" 
                                id="public_viewing_start" 
                                wire:model="public_viewing_start"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('public_viewing_start')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="public_viewing_end" class="block my-2 text-sm font-medium text-gray-900 ">Public Viewing End Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="public_viewing_end" 
                                id="public_viewing_end" 
                                wire:model="public_viewing_end"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('public_viewing_end')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="family_viewing_start" class="block my-2 text-sm font-medium text-gray-900 ">Family Viewing Start Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="family_viewing_start" 
                                id="family_viewing_start" 
                                wire:model="family_viewing_start"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('family_viewing_start')" class="mt-2" />
                            </div>

                            <div class="w-full ">
                                <label for="family_viewing_end" class="block my-2 text-sm font-medium text-gray-900 ">Family Viewing End Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="family_viewing_end" 
                                id="family_viewing_end" 
                                wire:model="family_viewing_end"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('family_viewing_end')" class="mt-2" />
                            </div>



                        </div>

                        <!-- Family Arrival-->
                        <div class="w-full border rounded-lg p-4">
                            <label for="family_arrival" class="block my-2 text-sm font-medium text-gray-900 ">Family Arrival</label>
                            
                            <x-input-error :messages="$errors->get('family_arrival')" class="mt-2" />
                           
                            <div class="grid grid-cols-1  gap-y-2 sm:gap-y-0 gap-x-2  "  >


                                

                                @foreach ($familyArrivals as $index => $arrival)
                                    <div class="grid grid-cols-1 sm:grid-cols-8  gap-2 mb-2">
                                        <div class=" sm:col-span-1">
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
                        <!-- ./ Family Arrival -->

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


    {{-- <script>
        document.addEventListener('livewire:load', () => {
            function initFlatpickrs() {
                

                // Initialize dynamic familyArrivals
                document.querySelectorAll('.flatpickr-input').forEach(el => {
                    if (!el._flatpickr) {
                        const index = el.dataset.index;
                        flatpickr(el, {
                            enableTime: true,
                            noCalendar: true,
                            dateFormat: "h:i K",
                            minuteIncrement: 30,
                            onChange: function(selectedDates, dateStr) {
                                Livewire.find(el.closest('[wire\\:id]').getAttribute('wire:id'))
                                    .set(`familyArrivals.${index}.time`, dateStr);
                            }
                        });
                    }
                });
            }
            $(document).ready(function() {
            // Run initially
            initFlatpickrs();
            });

            // Re-run after Livewire DOM updates
            Livewire.hook('message.processed', (message, component) => {
                initFlatpickrs();
            });
        });
    </script> --}}


@endpush

</section>
