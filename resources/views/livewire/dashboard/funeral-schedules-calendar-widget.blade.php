<section class="bg-white  antialiased scroll-mt-16 @if(request()->routeIs('dashboard')) sm:scroll-mt-32 @endif" id="funeral_schedules_calendar_widget">
    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:px-6   ">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold leading-tight tracking-tight text-gray-900 ">
                Funeral Calendar
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

            <div class="my-2 divide-y divide-gray-200 ">
                <div x-data="{ dateRange: @entangle('date_range') }" class="">
                    <input 
                        x-ref="datepicker" 
                        x-init="flatpickr($refs.datepicker, {
                            mode: 'range',
                            dateFormat: 'm d Y',
                            onChange: function(selectedDates, dateStr) {
                                dateRange = dateStr;
                            }
                        })"
                        wire:model.live="date_range"
                        type="text"
                        class="bg-white border border-gray-300 text-sm text-center rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 w-full"
                        placeholder="Select date range"
                    >
                </div>
            </div>


        </div>
        <div class="flow-root max-w-3xl mx-auto mt-8 sm:mt-12 lg:mt-16">

            

            <div class="-my-4 divide-y divide-gray-200 ">

                <div wire:ignore>
                    <div id="funeral-calendar"></div>
                </div>

            </div>
        </div>

        <script>
            /*
            document.addEventListener('DOMContentLoaded', function () {
                const calendarEl = document.getElementById('funeral-calendar');

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: @json($calendar_events), // if inside Livewire view
                    height: 'auto',

                     


                    
                    headerToolbar: { 
                        center: 'dayGridMonth,timeGridWeek,timeGridDay'
                     }, // buttons for switching between views

                    views: {
                        dayGridMonth: { // name of view
                            // titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
                        // other view-specific options here
                        }
                    },

                    eventDidMount: function(info) {
                        info.el.setAttribute('title', info.event.full_description);
                    },
                    eventClick: function(info) {
                        if (info.event.url) {
                            info.jsEvent.preventDefault(); // prevents default browser behavior
                            window.location.href = info.event.url;
                        }
                    }
                });

                calendar.render();


                 



            });*/

            /*
            // Listen for Livewire `navigate` events
            document.addEventListener('livewire:navigated', () => {
                const calendarEl = document.getElementById('funeral-calendar');

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    events: @json($calendar_events), // if inside Livewire view
                    height: 'auto',

                         
                    headerToolbar: { 
                        center: 'dayGridMonth,timeGridWeek,timeGridDay'
                        }, // buttons for switching between views

                    views: {
                        dayGridMonth: { // name of view
                            // titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
                        // other view-specific options here
                        }
                    },

                    eventDidMount: function(info) {
                        info.el.setAttribute('title', info.event.full_description);
                    },
                    eventClick: function(info) {
                        if (info.event.url) {
                            info.jsEvent.preventDefault(); // prevents default browser behavior
                            window.location.href = info.event.url;
                        }
                    }
                });

                calendar.render();


                    



            });

            */

        </script>

        <script>
            let calendar;

            function initializeCalendar(events) {
                const calendarEl = document.getElementById('funeral-calendar');

                if (calendar) {
                    calendar.destroy(); // destroy previous instance
                }

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    events: events,
                    headerToolbar: {
                        center: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    eventDidMount: function(info) {
                        const desc = info.event.extendedProps.desc;
                        const title = info.event.title;

                        info.el.setAttribute('title', `${title}\n${desc}`);
                    },
                    eventClick: function(info) {
                        if (info.event.url) {
                            info.jsEvent.preventDefault();
                            window.location.href = info.event.url;
                        }
                    }
                });

                calendar.render();
            }

            document.addEventListener('livewire:navigated', () => {
                initializeCalendar(@json($calendar_events));
            });

            // Listen for browser event from Livewire
            window.addEventListener('calendarEventsUpdated', event => {
                initializeCalendar(event.detail.events);
            });
        </script>




    </div>
     
</section>
