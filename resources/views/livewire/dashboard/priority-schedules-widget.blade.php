<section class="bg-white  antialiased scroll-mt-16 @if(request()->routeIs('dashboard')) sm:scroll-mt-32 @endif" id="funeral_priority_schedules_widget">
    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:px-6   ">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold leading-tight tracking-tight text-gray-900  ">
                Today Schedules
            </h2>

            <div class="mt-4">
            <a href="{{ route('funeral_schedule.index') }}"
                wire:navigate
                title=""
                class="inline-flex items-center text-lg font-medium text-primary-600 hover:underline  ">
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
            <div class="-my-4 divide-y divide-gray-200  ">


                



                <!-- priority schedules -->
                    @if(!empty($schedules) && count($schedules) > 0)
                        @foreach ($schedules as $schedule)
                            <livewire:dashboard.schedule-widget :funeral_schedule="$schedule" />
                        @endforeach
                    @else

                        <section class=" py-4 antialiased   "
                           
                        >
                             

                            <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
                                <div class=" mx-auto ">
                                    <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl  flex align-middle space-x-4"> 
                                        No Schedules for Today
                                    </h2>
                                </div>
                            </div>

                        </section>


                    @endif
                <!-- ./ priority schedules -->


            </div>
        </div>
    </div>
</section>
