<section 
    x-data="{ selectedRecordId: null }"
    class="bg-gray-50  py-3 sm:py-5">


    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>



    <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
        <div class="relative overflow-visible bg-white shadow-md  sm:rounded-lg">
            <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                <div class="flex items-center flex-1 space-x-4">
                    <h5>
                        <span class="text-gray-500">All Activity Logs:</span>
                        <span class="">{{ $activity_logs->total() }}</span>
                    </h5>
                    


                </div>
                <div class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">

                    <form class="flex items-center">
                        <label for="simple-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 " fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input 
                            type="text" 
                            id="search" 
                            wire:model.live="search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 " 
                            placeholder="Search"  >
                        </div>
                    </form>
                    
 
                    <div>
                        <button id="sort-dropdownRadioButton" data-dropdown-toggle="sort-dropdownRadio" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button">
                            Sort By
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="sort-dropdownRadio" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-sm " data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
                            <ul class="p-3 space-y-1 text-sm text-gray-700 " aria-labelledby="sort-dropdownRadioButton">
                                @foreach ($sort_filters as $filter)
                                    <li>
                                        <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 ">
                                            <input 
                                            wire:model.live="sort_by"
                                            id="sort-{{ Str::slug($filter) }}" 
                                            type="radio" 
                                            value="{{ $filter }}" 
                                            name="selected_sort" 
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500   focus:ring-2 ">
                                            <label for="sort-{{ Str::slug($filter) }}" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm ">{{ $filter }}</label>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <button
                     type="button" 
                    {{ $count == 0 ? 'disabled' : '' }}
                    wire:click="deleteAll" 
                    wire:confirm.prompt="Are you sure?\n\nType DELETE to confirm|DELETE"
                    class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300  focus:outline-none disabled:bg-red-300 disabled:pointer-events-none ">
                        <svg class="h-3.5 w-3.5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0L284.2 0c12.1 0 23.2 6.8 28.6 17.7L320 32l96 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 96C14.3 96 0 81.7 0 64S14.3 32 32 32l96 0 7.2-14.3zM32 128l384 0 0 320c0 35.3-28.7 64-64 64L96 512c-35.3 0-64-28.7-64-64l0-320zm96 64c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16z"/></svg>
                        Delete All ({{ $count }})
                    </button>
 
                   



                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input 
                                    id="checkbox-all" 
                                    type="checkbox" 
                                    wire:model.live="selectAll"
                                    wire:click="toggleSelectAll"
                                    wire:change="updateSelectedCount"
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 ">
                                    <label for="checkbox-all" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-4 py-3">Description</th>
                            <th scope="col" class="px-4 py-3">Event</th>
                            <th scope="col" class="px-4 py-3">Caused By</th>
                            <th scope="col" class="px-4 py-3">Date</th>  
                            <th scope="col" class="p-4"> 
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($activity_logs) && count($activity_logs) > 0)
                            @foreach ($activity_logs as $log) 
                                <tr class="border-b  hover:bg-gray-100 ">
                                      <td class="w-4 px-4 py-3">
                                        <div class="flex items-center">
                                            <input id="record-{{ $log->id }}" 
                                            wire:model="selected_records"
                                            wire:change="updateSelectedCount"
                                            type="checkbox" 
                                            value="{{ $log->id }}"
                                            class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 ">
                                            <label for="record-{{ $log->id }}" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap max-w-[20rem] text-wrap overflow-x-auto">
                                        {{ $log->description  ?? null }}
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap max-w-[10rem] text-wrap overflow-x-auto uppercase">
                                        {{ $log->event  ?? null }}
                                    </td>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap ">
                                        {{ $log->causer?->name ?? 'System' }}
                                    </td> 
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap ">
                                        {{  $log->updated_at->diffForHumans() ?? null }}
                                    </td>

                                    <td class="px-4 py-3 flex items-center justify-end">
                                        
                                        {{-- <a href="{{ route('log.edit',['log' => $log->id]) }}" class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  ">
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>
                                        </a> --}}
                                         
                                        <button type="button"   
                                        wire:click="delete({{ $log->id }})" 
                                        wire:confirm.prompt="Are you sure?\n\nType DELETE to confirm|DELETE"
                                        id="record-{{ $log->id }}-deleteButton"  
                                        class="px-3 py-2 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  ">
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                        </button>
                                       

                                        

                                    </td>  
                                </tr>
                            @endforeach
                        @else
                            <tr class="border-b     ">
                                <td class="w-4 px-4 py-3">
                                     
                                </td>
                                <td colspan="5" class="flex items-center px-4 py-2 font-medium text-gray-900 whitespace-nowrap hover:bg-gray-100"> 
                                    No records found
                                </td>
                                
                            </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
            <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0" aria-label="Table navigation">
                {{ $activity_logs->links() }}

                <div class="inline-flex items-center gap-x-2">
                    <p class="text-sm text-gray-600 ">
                    Showing:
                    </p>
                    <div class="max-w-sm space-y-3">
                    <select wire:model.live="record_count" class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500   ">
                        @foreach ($record_count_filters as $record_count_filter )
                            <option>{{ $record_count_filter }}</option>
                        @endforeach
                        
                    </select>
                    </div>
                    <p class="text-sm text-gray-600 ">
                        {{ count($activity_logs) > 0 ? 'of '.$activity_logs->total()  : '' }}
                    </p>
                </div>
            </nav>
        </div>
    </div>

      

    {{-- @endsection --}}

    
</section>