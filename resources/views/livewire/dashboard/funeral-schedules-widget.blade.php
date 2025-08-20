<section class="bg-white  antialiased scroll-mt-16 @if(request()->routeIs('dashboard')) sm:scroll-mt-32 @endif" id="funeral_schedules_widget">
    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:px-6   ">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold leading-tight tracking-tight text-gray-900 ">
            Funeral Schedules
            </h2>

            <div class="mt-4">
            <a href="{{ route('funeral_schedule.index') }}"
                wire:navigate
                title=""
                class="inline-flex items-center text-lg font-medium text-primary-600 hover:underline ">
                View All Schedules
                <svg aria-hidden="true" class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
            </a>
            </div>
        </div>

        <div class="flow-root max-w-3xl mx-auto mt-8 sm:mt-12 lg:mt-16">
            <div class="-my-4 divide-y divide-gray-200 ">
                @if(!empty($funeral_schedules) && count($funeral_schedules) > 0)
                    @foreach ($funeral_schedules as $funeral_schedule)
                        <a  href="{{ route('funeral_schedule.show',['funeral_schedule' => $funeral_schedule->id]) }}"  class="flex flex-col gap-2 py-4 sm:gap-6 sm:flex-row sm:items-start justify-center hover:bg-gray-50">
                            <p class="w-32 text-lg font-normal text-gray-500 sm:text-right  shrink-0 ">

                                {{ $funeral_schedule->date ? $funeral_schedule->date->format('M d, Y') : '' }}
 

                                <span class="text-gray-400 text-xs block my-0 ">
                                    CEMETERY
                                </span>



                                <span class="text-gray-500 text-sm block my-0 font-bold">
                                    {{ $funeral_schedule->burial_cemetery  ?? null }}
                                </span>

                                 <span class="text-gray-500 text-xs block my-0">
                                    {{ $funeral_schedule->burial_location  ?? null }}
                                </span>

                                
 
                            </p>
                            <h3 class="text-lg font-semibold text-gray-900 ">
                                <div  >
                                    {{ $funeral_schedule->name_of_person }}

                                    
 

                                    <span class="text-sm block my-0"> 
                                        <span class="block my-0">
                                            <span class="text-xs uppercase text-gray-500">
                                                MASS TIME:
                                            </span>

                                            <span class="text-gray-600">
                                               {{  $funeral_schedule->mass_time->format("h:i A") ?? null }}
                                            </span>
                                             
                                        </span>
                                        

                                        <span class="block my-0">
                                            <span class="text-xs uppercase text-gray-500">
                                                PUBLIC VIEW TIME:
                                            </span>

                                            <span class="text-gray-600">
                                               {{  $funeral_schedule->public_viewing_start->format("h:i A")." - ".$funeral_schedule->public_viewing_end->format("h:i A") ?? null }}
                                            </span>
                                             
                                        </span>

                                        <span class="block my-0">
                                            <span class="text-xs uppercase text-gray-500">
                                                FAMILY VIEW TIME:
                                            </span>

                                            <span class="text-gray-600">
                                               {{  $funeral_schedule->family_viewing_start->format("h:i A")." - ".$funeral_schedule->family_viewing_end->format("h:i A") ?? null }} 
                                            </span>
                                             
                                        </span>
                                        
                                        {{-- <span class="text-gray-500">Public:</span> {{  $funeral_schedule->public_viewing_start->format("h:i A")." to ".$funeral_schedule->public_viewing_end->format("h:i A") ?? null }}  
                                        <span class="text-gray-500">Family:</span> {{  $funeral_schedule->family_viewing_start->format("h:i A")." to ".$funeral_schedule->family_viewing_end->format("h:i A") ?? null }} --}}
                                    </span> 

                                     
                                   


                                </div>
                            </h3>
                        </a>
                    @endforeach
                @else
                    <section class=" py-4 antialiased   "
                           
                        >
                             

                        <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
                            <div class=" mx-auto ">
                                <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl  flex align-middle space-x-4"> 
                                    No Schedules Found
                                </h2>
                            </div>
                        </div>

                    </section>

                @endif

                
               
            </div>
        </div>
    </div>
</section>