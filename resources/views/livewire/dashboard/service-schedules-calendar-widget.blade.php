<section class="bg-white  antialiased scroll-mt-16 @if(request()->routeIs('dashboard')) sm:scroll-mt-32 @endif" id="service_schedules_calendar_widget">
    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:px-6   ">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl font-extrabold leading-tight tracking-tight text-gray-900 ">
                Service Schedules Calendar
            </h2>

            <div class="mt-4">
                <a href="{{ route('service_schedule.index') }}" 
                    wire:navigate
                    title=""
                    class="inline-flex items-center text-lg font-medium text-primary-600 hover:underline ">
                    View All Service Schedules
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
                    <div id="service-funeral-calendar"></div>
                </div>

            </div>
        </div>

         

        <script>
            let service_calendar;

            function initializeServiceCalendar(events) {
                const calendarElFuneral = document.getElementById('service-funeral-calendar');

                if (service_calendar) {
                    service_calendar.destroy(); // destroy previous instance
                }

                service_calendar = new FullCalendar.Calendar(calendarElFuneral, {
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    events: events,
                    timeZone: 'UTC',          // Use Coordinated Universal Time

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

                service_calendar.render();
            }

            document.addEventListener('livewire:navigated', () => {
                initializeServiceCalendar(@json($calendar_events));
            });

            // Listen for browser event from Livewire
            window.addEventListener('serviceCalendarEventsUpdated', event => {
                initializeServiceCalendar(event.detail.events);
            });
        </script>

        



    </div>
     
</section>
