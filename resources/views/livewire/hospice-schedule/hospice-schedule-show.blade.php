<section class=" py-4 antialiased   ">
    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl ">Hospice Schedule Details</h2>
            <p class="text-sm text-gray-500 mb-2">Last updated {{ $updated_at->diffForHumans() }}</p>
                    
            <div class="mx-auto max-w-6xl space-y-6">
                

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        
                        <tbody>
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-start">
                                   Name 
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $name }}
                                </td>  
                            </tr>
 

                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white text-start">
                                    Hospice Schedule Date  
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $date_range }}
                                </td>  
                            </tr>

                          
 

                             
                        </tbody>
                    </table>
                </div>
                

            </div>
            <div class="mt-2 px-4 py-3 flex items-center justify-end">   
                 

               

                @if(!empty($hospice_schedule->funeral_schedules->first()))
                    @php 
                        $funeral_schedule_id = $hospice_schedule->funeral_schedules->first()->id;
                    @endphp
                    <!-- show-funeral-schedule -->
                        <a href="{{ route('funeral_schedule.show',['funeral_schedule' => $funeral_schedule_id]) }}" 
                            wire:navigate
                            data-tooltip-target="tooltip-btn-show-funeral-schedule-{{ $hospice_schedule->id }}"
                            class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300  ">
                             <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M176 0c-26.5 0-48 21.5-48 48l0 80-80 0c-26.5 0-48 21.5-48 48l0 32c0 26.5 21.5 48 48 48l80 0 0 208c0 26.5 21.5 48 48 48l32 0c26.5 0 48-21.5 48-48l0-208 80 0c26.5 0 48-21.5 48-48l0-32c0-26.5-21.5-48-48-48l-80 0 0-80c0-26.5-21.5-48-48-48L176 0z"/></svg>
                        </a>
                        <div id="tooltip-btn-show-funeral-schedule-{{ $hospice_schedule->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                            Show Funeral Schedule
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    <!-- ./ show-funeral-schedule -->
                @else
                    <!-- create-funeral-schedule -->
                        <a href="{{ route('funeral_schedule.create',['hospice_schedule_id' => $hospice_schedule->id]) }}" 
                            wire:navigate
                            data-tooltip-target="tooltip-btn-create-funeral-schedule-{{ $hospice_schedule->id }}" 
                            class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-sky-700 rounded-lg hover:bg-sky-800 focus:ring-4 focus:outline-none focus:ring-sky-300  "> 
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M176 0c-26.5 0-48 21.5-48 48l0 80-80 0c-26.5 0-48 21.5-48 48l0 32c0 26.5 21.5 48 48 48l80 0 0 208c0 26.5 21.5 48 48 48l32 0c26.5 0 48-21.5 48-48l0-208 80 0c26.5 0 48-21.5 48-48l0-32c0-26.5-21.5-48-48-48l-80 0 0-80c0-26.5-21.5-48-48-48L176 0z"/></svg>
                        </a>
                        <div id="tooltip-btn-create-funeral-schedule-{{ $hospice_schedule->id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip dark:bg-gray-700">
                            Create Funeral Schedule
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    <!-- ./ create-funeral-schedule -->
                @endif
            </div>
            
            
             
        </div>
    </div>
</section>