<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>

        <script>
            window.currentUser = {
                id: {{ Auth::id() }},
                roles: {!! json_encode(Auth::user()?->getRoleNames() ?? []) !!},
                permissions: {!! json_encode(Auth::user()?->getAllPermissions()->pluck('name') ?? []) !!}
            };
        </script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FHRS') }}</title>

        <link rel="icon" type="image/jpg" href="{{ asset('images/bird.jpg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- In your Blade or HTML layout -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

        

        {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script> --}}


        <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>


        <!-- Include Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

        <!-- Include Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>


        <script src="https://unpkg.com/libphonenumber-js@1.10.18/bundle/libphonenumber-js.min.js"></script>

        <link rel="manifest" href="{{ asset('manifest.json') }}">

        


        {{-- <script src="./assets/vendor/preline/dist/preline.js"></script> --}}
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            <div wire:loading
                class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <span class="loader"></span>
            </div>

              

            <!-- Page Content -->
            <main class=""> 

                

                {{ $slot }}
            </main>
        </div>

 

        @livewireScripts


        @section('scripts')

        <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

        <script>
            function highlightActiveHashLink() {
                const links = document.querySelectorAll('a[href^="#"]');

                // Remove existing highlights
                links.forEach(link => {
                    link.classList.remove('text-blue-700', 'border-blue-700', 'font-semibold');
                });

                // Highlight the current hash link
                const currentHash = window.location.hash;
                const activeLink = document.querySelector(`a[href="${currentHash}"]`);
                if (activeLink) {
                    activeLink.classList.add('text-blue-700', 'border-blue-700', 'font-semibold');
                }
            }

            // Run on initial load
            document.addEventListener("DOMContentLoaded", highlightActiveHashLink);

            // Run when hash changes (like clicking a section link)
            window.addEventListener("hashchange", highlightActiveHashLink);

            // Optional: run after Livewire updates the DOM
            document.addEventListener("livewire:load", () => {
                Livewire.hook('message.processed', (message, component) => {
                    highlightActiveHashLink();
                });
            });
        </script>



        <!-- Push custom scripts from views -->
        @stack('scripts')  <!-- This will include any scripts pushed to the stack -->


        <script>
            const session_notyf = new Notyf({
                duration: 1000,
                position: {
                    x: 'right',
                    y: 'top',
                },
                types: [
                    {
                        type: 'success',
                        background: 'green',
                        duration: 10000,
                        dismissible: true
                    },
                    {
                        type: 'warning',
                        background: 'orange',
                        icon: {
                            className: 'material-icons',
                            tagName: 'i',
                            text: 'warning'
                        },
                        duration: 10000,
                        dismissible: true
                    },
                    {
                        type: 'error',
                        background: 'indianred',
                        duration: 10000,
                        dismissible: true
                    }
                ]
            });

            @if(session('alert.error'))
                session_notyf.open({
                    type: 'error',
                    message: '{{ session('alert.error') }}'
                });
            @elseif(session('alert.success'))
                session_notyf.open({
                    type: 'success',
                    message: '{{ session('alert.success') }}'
                });
            @elseif(session('alert.warning'))
                session_notyf.open({
                    type: 'warning',
                    message: '{{ session('alert.warning') }}'
                });
            @endif
        </script>

        <script>
            function openFullscreen() {
                const elem = document.documentElement;
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                }
            }
        </script>

    </body>
</html>
