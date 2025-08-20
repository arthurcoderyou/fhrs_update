<section class=" py-4 antialiased   ">
    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div  class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl  flex align-middle space-x-4"> 
                <span>Settings </span> 
                <div class="  flex items-center justify-end">


                    @if(Auth::check() && (Auth::user()->can('setting create') ||  Auth::user()->hasRole('Global Administrator')) )

                    <!-- add setting -->
                        <a href="{{ route('setting.create') }}" 
                            data-tooltip-target="tooltip-btn-add-setting"
                            class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-orange-700 rounded-lg hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300  ">
                            
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 144L48 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l144 0 0 144c0 17.7 14.3 32 32 32s32-14.3 32-32l0-144 144 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-144 0 0-144z"/></svg>
                        </a>
                        <div id="tooltip-btn-add-setting" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip ">
                            Add Setting 
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    <!-- ./ add setting -->

                    <!-- update setting -->
                        <a href="{{ route('setting.whatsapp.edit') }}" 
                            data-tooltip-target="tooltip-btn-update-setting"
                            class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300  ">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                        </a>
                        <div id="tooltip-btn-update-setting" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip ">
                            Whatsapp Setting
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    <!-- ./ update setting -->
                    @endif
                </div>
                
            </h2>
            {{-- <p class="text-sm text-gray-500 mb-2">Last updated {{ $updated_at->diffForHumans() }}</p> --}}
            
          
            <div class="mx-auto max-w-6xl space-y-6">
                

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        
                        <tbody>
                            @if(!empty($settings) && count($settings) > 0)
                                @foreach ($settings as $key => $setting)
                                    <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                            <div class="flex space-x-2">

                                                @if(Auth::check() &&   Auth::user()->hasRole('Global Administrator')) 
                                                <div class="flex flex-col">
                                                    <button {{ $setting['order']  == 1 ? 'disabled' : '' }} type="button" 
                                                        {{-- wire:click="updateOrder( {{ $reviewer['id'] }},{{ $reviewer['order'] }},'move_up',{{ $reviewer['document_type_id'] ?? 0 }}, '{{ $reviewer['reviewer_type'] }}' )"  --}}
                                                        wire:click="updateOrder( {{ $setting['id'] }},{{ $setting['order'] }},'move_up'  )"
                                                        class="p-1 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none  " >
                        
                                                        <div class="hs-tooltip flex">
                        
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>
                                                            <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm " role="tooltip">
                                                                Move order up
                                                            </span>
                                                        </div>
                        
                        
                                                    </button>
                        
                        
                                                    
                                                    <button {{ $setting['order'] == $lastOrder ? 'disabled' : '' }} type="button" 
                                                        {{-- wire:click="updateOrder( {{ $reviewer['id'] }},{{ $reviewer['order'] }},'move_down',{{ $reviewer['document_type_id'] ?? 0 }} , '{{ $reviewer['reviewer_type'] }}' )"  --}}
                                                        wire:click="updateOrder( {{ $setting['id'] }},{{ $setting['order'] }},'move_down'  )"
                                                        class="p-1 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none  " >
                                                        <div class="hs-tooltip flex">
                        
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                            </svg>
                                                            <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm " role="tooltip">
                                                                Move order down
                                                            </span>
                                                        </div>
                        
                        
                                                    </button>
                        
                                                </div>
                                                @endif


                                                <div>

                                                    {{ $setting['name'] }}  <br>

                                                    @if(Auth::check() &&   Auth::user()->hasRole('Global Administrator'))  
                                                        <span class="text-sm text-gray-500">{{ $key }}</span> <br> 
                                                    @endif
        
                                                    <span class="text-sm text-gray-700">{{ $setting['value'] }}</span>   <br> 
                                                
                                                </div>
                                            </div>
 
                                        </th>
 

                                        <td class="px-6 py-4 text-end flex justify-end align-center gap-x-1">
                                            @if($setting['type'] == "text" || $setting['type'] == "long_text" ) 
                                                <div class="px-3 py-2">
                                                    {{ $setting['value'] ? "SET" : "NOT SET" }}
                                                </div>
                                                 
                                            @endif
                                            

                                            @if((Auth::check() && (Auth::user()->can('setting edit')) ||  Auth::user()->hasRole('Global Administrator')) )
                                            <!-- edit setting -->
                                                <a href="{{ route('setting.edit',['setting' => $setting['id']]) }}" 
                                                    data-tooltip-target="tooltip-btn-edit-setting-{{ $setting['id'] }}"
                                                    class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  ">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>
                                                </a>
                                                <div id="tooltip-btn-edit-setting-{{ $setting['id'] }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip ">
                                                    Edit Settings
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>
                                            <!-- ./ edit setting -->
                                            @endif 


                                            @if(Auth::check() && (Auth::user()->can('setting delete') ||  Auth::user()->hasRole('Global Administrator')) )

                                             <!-- delete-setting -->
                                                <button type="button"   
                                                data-tooltip-target="tooltip-btn-delete-setting-{{ $setting['id'] }}"
                                                wire:click="delete({{ $setting['id'] }})" 
                                                wire:confirm.prompt="Are you sure?\n\nType DELETE to confirm|DELETE"
                                                id="record-{{ $setting['id'] }}-deleteButton"  
                                                class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  ">
                                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                                </button>
                                                <div id="tooltip-btn-delete-setting-{{ $setting['id'] }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip ">
                                                    Delete Funeral Schedule
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>
                                            <!-- ./ delete-setting -->
                                            @endif


                                        </td>  

                                        
                                    </tr>  


                                    <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                        <th colspan="2" scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                            
                                            <span class="text-sm text-gray-500">Update {{ $setting['name'] }}</span> <br> 
 

                                            @if ($setting['type'] === 'text')
                                                <input type="text"  
                                                    required
                                                    name="{{ $key }}"
                                                    wire:model.lazy="settings.{{ $key }}.value"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" />
                                            @elseif ($setting['type'] === 'number')
                                                <input type="number" 
                                                    required 
                                                    name="{{ $key }}"
                                                    wire:model.lazy="settings.{{ $key }}.value"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" />
                                            @elseif ($setting['type'] === 'selection')


                                               <select
                                                    required
                                                    name="{{ $key }}"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                                   wire:model.lazy="settings.{{ $key }}.value"
                                                >
                                                    <option value="" selected>Select option</option>
                                                    @foreach ($setting['options'] as $option)
                                                        <option value="{{ $option }}">{{ $option }}</option>
                                                    @endforeach
                                                </select>


                                            @elseif ($setting['type'] === 'long_text')
                                                <textarea 
                                                    name="{{ $key }}"
                                                    required
                                                    wire:model.lazy="settings.{{ $key }}.value"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 h-24"></textarea>
                                            @endif

 
                                        </th>
  
                                    </tr>  

                                    





                                @endforeach
                                
                            @else
                                <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                        No Settings Configured
                                    </th>
                                    <td class="px-6 py-4 text-end">
                                         
                                    </td>  
                                </tr>  
                            @endif
 

                             
                        </tbody>
                    </table>
                </div>
                <!-- #endregion -->
             
            </div>

            
             
             
        </div>
    </div>
</section>