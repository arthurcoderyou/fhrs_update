<section class=" py-4 antialiased   ">
    <div wire:loading
        class="fixed inset-0   z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <div class="gap-4 sm:flex sm:items-center sm:justify-between overflow-auto ">
                <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl">Edit Service Schedule Details</h2>
            </div>
            <!-- Modal content -->
            <div class="relative  py-2  rounded-lg   ">
                 
                <!-- Modal body -->
                <form wire:submit="save">
                    <div class=" gap-4 mb-4 grid  ">
                        <div class="grid grid-cols-1 sm:grid-cols-2   gap-y-2 sm:gap-y-0 gap-x-2  ">

                            <div class="w-full ">
                                <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 ">Staff</label>
                                {{-- <select 
                                @readonly(true)
                                id="user_id" 
                                name="user_id"
                                wire:model.live="user_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                    <option selected="">Select user</option>
                                    @if(!empty($users))
                                        @foreach ($users as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    @endif
                                </select> --}}
                                <input  
                                    readonly
                                    
                                    wire:model.live="user"
                                    type="text"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 w-full"
                                    placeholder="Select date range"
                                > 

                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>


                            <div x-data="{ dateRange: @entangle('date_range') }" class="w-full">
                                <label for="date" class="block mb-2 text-sm font-medium text-gray-900 ">Date (MM DD YYYY)  </label>
                                <input  
                                    readonly
                                    
                                    wire:model.live="date_range"
                                    type="text"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 w-full"
                                    placeholder="Select date range"
                                > 
                                <x-input-error :messages="$errors->get('date_range')" class="mt-2" /> 
                                {{-- <x-input-error :messages="$errors->get('start_date')" class="mt-2" /> 
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />  --}}
                            </div>

                             
                            <div class="w-full ">
                                <label for="start_time" class="block my-2 text-sm font-medium text-gray-900 ">Start Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="start_time" 
                                id="start_time" 
                                wire:model.live="start_time"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                             <div class="w-full ">
                                <label for="end_time" class="block my-2 text-sm font-medium text-gray-900 ">End Time (HH:MM AM/PM)</label>
                                <input type="text" 
                                name="end_time" 
                                id="end_time" 
                                wire:model.live="end_time"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                           
 

                             
                            
                        </div>
                         
                    </div>
                    <button 
                    type="button" 
                    wire:click="save"
                    wire:confirm="Are you sure?"
                    class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Save
                    </button>
                    <a href="{{ route('service_schedule.index') }}" 
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
                flatpickr("#start_time", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K",

                    minuteIncrement: 30,
                    onChange: function(selectedDates, dateStr, instance) {
                        @this.set('start_time', dateStr);
                    }
                });
            });

            $(document).ready(function() {
                flatpickr("#end_time", {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "h:i K",

                    minuteIncrement: 30,
                    onChange: function(selectedDates, dateStr, instance) {
                        @this.set('end_time', dateStr);
                    }
                });
            });
              

        </script>

    @endpush
</section>
