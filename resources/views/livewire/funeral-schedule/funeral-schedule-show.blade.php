<section class=" py-4 antialiased   ">
    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl  flex align-middle space-x-4"> 
                <span>Funeral Schedule Details </span> 
                @auth
                    
               
                    @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit') )
                        <div class="  flex items-center justify-end">
                            <!-- edit-funeral-schedule -->
                                <a href="{{ route('funeral_schedule.edit',['funeral_schedule' => $funeral_schedule_id]) }}" wire:navigate
                                    data-tooltip-target="tooltip-btn-edit-funeral-schedule-{{ $funeral_schedule_id }}"
                                    class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  ">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>
                                </a>
                                <div id="tooltip-btn-edit-funeral-schedule-{{ $funeral_schedule_id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip ">
                                    Update Funeral Schedule
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            <!-- ./ edit-funeral-schedule -->


                            


                        </div>

 
                    @endif

                @endauth
                
            </h2>
            <p class="text-sm text-gray-500 mb-2">Last updated {{ $updated_at->diffForHumans() }}</p>

            @auth
                
            
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

            @endauth


            <div class="mx-auto max-w-6xl space-y-6">
                

                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                        
                        <tbody>
                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Name of Person
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $name_of_person }}
                                </td>  
                            </tr>
                            @auth
                                

                            @if(Auth::user()->hasRole("Global Administrator"))
                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Folder
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $folder }}
                                </td>  
                            </tr>
                            @endif

                            @endauth

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Date
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $date }}
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Mass Time
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $mass_time }}
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                  Public Viewing
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $public_viewing_start  }} to {{ $public_viewing_end }}
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Family Viewing
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $family_viewing_start  }} to {{ $family_viewing_end }}
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Burial Cemetery
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $burial_cemetery  }} 
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Burial Location
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $burial_location  }}  
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Hearse
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $hearse  }}  
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Funeral Director
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $funeral_director  }}  
                                </td>  
                            </tr>

                            <tr class="odd:bg-white  even:bg-gray-50  border-b  border-gray-200">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap  text-start">
                                   Co-Director
                                </th>
                                <td class="px-6 py-4 text-end">
                                    {{ $co_funeral_director  }}  
                                </td>  
                            </tr>

 

                             
                        </tbody>
                    </table>
                </div>

                @auth 
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

                    @if(!empty($familyPointOfContact) && count($familyPointOfContact))
                        <div class="mb-2">
                            
                                <p class="text-base font-semibold text-gray-900  mb-2">Family Point of Contact:</p>
                                <ul class="list-outside list-disc space-y-4 pl-4 text-base font-normal text-gray-500 ">

                                    @foreach ($familyPointOfContact as $contact)
                                        <li>
                                            <span class="font-semibold text-gray-900 "> {{ $contact['phone'] }}: </span>
                                            {{ $contact['notes'] }}
                                        </li>
                                    @endforeach
                                    
                                </ul>
                            
                        </div>
                    @endif



                    @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule view attachments') )
                    @if(isset($existingFiles) && count($existingFiles) > 0)
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

                                                        $attachment_file  = "";

                                                        $attachment_file = route('ftp.download', ['id' => $attachment['id']]);

                                                        
                                                        ?>



                                                        <div class="dz-flex dz-items-center dz-justify-between dz-gap-2 dz-border dz-rounded dz-border-gray-200 dz-w-full">
                                                            <div class="dz-flex dz-items-center dz-gap-3">
                                                                @if(!empty($attachment_file ) && isImageMime($attachment_file))
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
                                                                {{-- <a 
                                                                    href="{{ asset('storage/uploads/funeral_attachments/' . $attachment['attachment']) }}" 
                                                                    download="{{ $attachment['attachment'] }}" 
                                                                    class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                                                    
                                                                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <path fill="#ffffff" d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                                                    </svg>
                                                                </a> --}}


                                                                <a 
                                                                    href="{{ route('ftp.download', ['id' => $attachment['id']]) }}" 
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
                @endauth


            </div>

            
            
             
        </div>
    </div>


    


</section>