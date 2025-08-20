<section class=" py-4 antialiased   ">
    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <h2 class="text-xl font-semibold text-gray-900   sm:text-2xl  flex align-middle space-x-4"> 
                <span>Service Schedule Details </span> 

                {{-- @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit') ) --}}
                <div class="  flex items-center justify-end">
                    <!-- edit-funeral-schedule -->
                        <a href="{{ route('service_schedule.edit',['service_schedule' => $service_schedule_id]) }}" 
                            wire:navigate
                            data-tooltip-target="tooltip-btn-edit-funeral-schedule-{{ $service_schedule_id }}"
                            class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  ">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>
                        </a>
                        <div id="tooltip-btn-edit-funeral-schedule-{{ $service_schedule_id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip ">
                            Update Service Schedule
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    <!-- ./ edit-funeral-schedule -->
                </div>
                {{-- @endif --}}
                
            </h2>
            <p class="text-sm text-gray-500 mb-2">Last updated {{ $updated_at->diffForHumans() }}</p>
            
            


            <div class="mx-auto max-w-6xl space-y-6">
                

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        
                        <tbody>
                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap   text-start">
                                   Name of Staff
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $user_name }}
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap   text-start">
                                   Schedule Date
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $schedule_date }}
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap   text-start">
                                   Start Time
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $start_time }}
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap   text-start">
                                   End Time
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $end_time }}
                                </td>  
                            </tr>
 

 

                             
                        </tbody>
                    </table>
                </div>
 

 

            </div>

            
            
             
        </div>
    </div>
</section>