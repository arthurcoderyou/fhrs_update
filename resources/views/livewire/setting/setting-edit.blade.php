<section class=" py-4 antialiased   ">
    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <div class="gap-4 sm:flex sm:items-center sm:justify-between overflow-auto ">
                <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl">Update Settings</h2>
            </div>
            <!-- Modal content -->
            <div class="relative  py-2  rounded-lg   ">
                 
                <!-- Modal body -->
                <form wire:submit="save">
                    <div class=" gap-4 mb-4 grid  ">
                        <div class="grid grid-cols-1 sm:grid-cols-3   gap-y-2 sm:gap-y-0 gap-x-2  ">

                            <div class="w-full ">
                                <label for="key" class="block my-1 text-sm font-medium text-gray-900 ">Key</label>
                                <input type="text" 
                                name="key" 
                                id="key" 
                                wire:model="key"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                              
                            <div class="w-full ">
                                <label for="name" class="block my-1 text-sm font-medium text-gray-900 ">Name</label>
                                <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                wire:model="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                 >
                                 <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            
                            <div class="w-full ">
                                <label for="value_type" class="block my-1 text-sm font-medium text-gray-900 ">Setting type</label>
                                <select
                                disabled 
                                id="value_type" 
                                name="value_type"
                                wire:model.live="value_type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 ">
                                    <option selected="">Select type</option>
                                    @if(!empty($value_types))
                                        @foreach ($value_types as $type_key => $type_description)
                                            <option value="{{ $type_key }}">{{ $type_description }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>
                            
                        </div>
                         
                         
                        @if($value_type == "selection")
                        <!-- setting_options -->
                            <div class="w-full border rounded-lg p-4">
                                <label for="setting_options" class="block my-2 text-sm font-medium text-gray-900 ">Setting options</label>
                                
                                <x-input-error :messages="$errors->get('value')" class="mt-2" />
                            
                                <div class="grid grid-cols-1  gap-y-2 sm:gap-y-0 gap-x-2  "  >

 
                                    @foreach ($setting_options as $index => $equipment)
                                        <div class="grid grid-cols-1 sm:grid-cols-8  gap-2 mb-2">
                                            <div class=" sm:col-span-12 sm:flex gap-2">
 
                                                <input 
                                                    type="text" 
                                                    wire:model.defer="setting_options.{{ $index }}" 
                                                    class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" 
                                                    data-index="{{ $index }}" 
                                                    placeholder="Option"
                                                >


                                                <button type="button"
                                                class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  "
                                                wire:click="removeSettingOption({{ $index }})">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                                
                                                </button>
                                            
                                            </div> 
                                        </div>
                                    @endforeach

                                    <button 
                                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300  focus:outline-none "
                                    type="button"
                                    wire:click="addSettingOption">
                                        + Add Option
                                    </button>

                                </div>
                            </div> 
                        <!-- ./ Equipments -->
                        @endif

                    </div>
                    <button 
                    type="button" 
                    wire:click="save"
                    wire:confirm="Are you sure?"
                    class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Save
                    </button>
                    <a href="{{ route('setting.index') }}" class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Cancel
                    </a>
                </form>
            </div> 
        </div> 
    </div>





    
</section>
