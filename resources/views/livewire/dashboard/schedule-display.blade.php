<section class=" py-0 antialiased   "
    x-data="{ 
        positions: @entangle('positions'),
        options:  @entangle('options'),
        addItem(key) {
            const index = this.positions.indexOf(key);
            if (index !== -1) this.positions.splice(index, 1); // Remove existing
            this.positions.push(key); // Add to end
        },
         
            
        paddingLeft: @entangle('paddingLeft'),
        paddingRight: @entangle('paddingRight'),
        paddingTop: @entangle('paddingTop'),
        paddingBottom: @entangle('paddingBottom'),

        marginLeft: @entangle('marginLeft'),
        marginRight: @entangle('marginRight'),
        marginTop: @entangle('marginTop'),
        marginBottom: @entangle('marginBottom'), 


        labelSize: @entangle('labelSize'),
        labelLineHeight: @entangle('labelLineHeight'),
        labelColor: @entangle('labelColor'),
        labelFontWeight: @entangle('labelFontWeight'),
        labelFontStyle: @entangle('labelFontStyle'),
        labelLetterSpacing: @entangle('labelLetterSpacing'),

        valueSize: @entangle('valueSize'), 
        valueLineHeight: @entangle('valueLineHeight'),
        valueColor: @entangle('valueColor'),
        valueFontWeight: @entangle('valueFontWeight'),
        valueFontStyle: @entangle('valueFontStyle'),
        valueLetterSpacing: @entangle('valueLetterSpacing'),
            
 
     
        showModal: false,  
        handleKeydown(event) {
            if (event.keyCode == 191) {
                this.showModal = true; 
            }
            if (event.keyCode == 27) { 
                this.showModal = false; 
                $wire.search = '';
            }

        },
        search() {
            this.showModal = false;
            {{-- $wire.search = '';  --}}
        } 




    }",


>
    {{-- <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    

    <div 
        x-data="{ navigating: false }"
        x-on:navigating.window="navigating = true"
        x-on:navigated.window="navigating = false"
    >
        <!-- Overlay shown on wire:loading or wire:navigate -->
        <div
            x-show="navigating"
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
        >
            <span class="loader"></span>
        </div>

        <div wire:loading
            class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <span class="loader"></span>
        </div>
    </div> --}}

     <div wire:loading wire:target="filter_by"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div wire:loading wire:target="sort_by"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>


    {{-- <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  "> --}}
    <div  >


        <!-- fullscreen options -->
        <div
        id="fullscreenContainer"
        class="fullscreen-hide sticky top-0 z-30 bg-white/70  backdrop-blur supports-[backdrop-filter]:border-b border-gray-200/60 text-start"
        >
            <div class="mx-auto max-w-screen-2xl px-3 sm:px-4 lg:px-6">
                <div class="flex   gap-3 py-2 sm:py-3">
                    {{-- Left side: (optional) page title / breadcrumb --}}
                    <div class="min-w-0">
                        {{-- Uncomment if you want a label/title here --}}
                        {{-- <a href="{{ route('funeral_schedule.public.show',['funeral_schedule' => $funeral_schedule_id]) }}"
                        class="truncate text-sm sm:text-base font-semibold text-gray-800  hover:text-blue-600 ">
                        {{ $name_of_person }}
                        </a> --}}
                    </div>

                    {{-- Right side: actions --}}
                    <div class="flex items-center gap-2 sm:gap-3">
                        {{-- Fullscreen --}}
                        <button
                        type="button"
                        onclick="toggleFullscreen()"
                        data-tooltip-target="tooltip-fullscreen"
                        class="group inline-flex items-center gap-2 rounded-xl border border-gray-200  bg-white  px-3 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-gray-700  shadow-sm hover:bg-gray-50  focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/70 active:scale-[.99] transition"
                        title="Toggle fullscreen (F)"
                        aria-label="Toggle fullscreen"
                        id="fsBtn"
                        >
                            <svg class="size-4 sm:size-5 shrink-0 text-gray-700  group-hover:text-blue-600 "
                                viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true">
                                <path d="M32 32C14.3 32 0 46.3 0 64v96c0 17.7 14.3 32 32 32s32-14.3 32-32V96h64c17.7 0 32-14.3 32-32S145.7 32 128 32H32zM64 352c0-17.7-14.3-32-32-32S0 334.3 0 352v96c0 17.7 14.3 32 32 32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H64v-64zM320 32c-17.7 0-32 14.3-32 32s14.3 32 32 32h64v64c0 17.7 14.3 32 32 32s32-14.3 32-32V64c0-17.7-14.3-32-32-32h-96zM448 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64h-64c-17.7 0-32 14.3-32 32s14.3 32 32 32h96c17.7 0 32-14.3 32-32v-96z"/>
                            </svg>
                            <span class="hidden xs:inline">Fullscreen</span>
                            <span class="hidden md:inline text-[11px] font-normal text-gray-500  border border-gray-200  rounded px-1 py-0.5">F</span>

                            <div id="tooltip-fullscreen" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip  ">
                                Fullscreen
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                        </button>

                        {{-- Home --}}
                        <a
                        href="{{ route('welcome') }}"
                        wire:navigate
                        data-tooltip-target="tooltip-welcome"
                        class="group inline-flex items-center gap-2 rounded-xl border border-gray-200  bg-white  px-3 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-gray-700  shadow-sm hover:bg-gray-50  focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/70 active:scale-[.99] transition"
                        >
                            <svg class="size-4 sm:size-5 shrink-0 text-gray-700  group-hover:text-blue-600 "
                                viewBox="0 0 640 640" xmlns="http://www.w3.org/2000/svg" fill="currentColor" aria-hidden="true">
                                <path d="M341.8 72.6c-12.3-11.4-31.3-11.4-43.5 0l-224 208c-9.6 9-12.8 22.9-8 35.1S82.8 336 96 336h16v176c0 35.3 28.7 64 64 64h288c35.3 0 64-28.7 64-64V336h16c13.2 0 24.9-8.1 29.7-20.3s1.2-26.6-8.4-35.6l-224-208zM304 384h32c26.5 0 48 21.5 48 48v96H256v-96c0-26.5 21.5-48 48-48z"/>
                            </svg>
                            <span class="hidden xs:inline">Home</span>

                            <div id="tooltip-welcome" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip  ">
                                Home
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                        </a>

                        @if(Auth::check())
                            @if(Auth::user()->hasRole('Global Administrator') || Auth::user()->can('funeral schedule edit') )
                            <div class="  flex items-center justify-end">
                                <!-- edit-funeral-schedule -->
                                    <a href="{{ route('funeral_schedule.edit',['funeral_schedule' => $funeral_schedule_id]) }}" 
                                        wire:navigate
                                        data-tooltip-target="tooltip-btn-edit-funeral-schedule-{{ $funeral_schedule_id }}"
                                        class="me-1.5 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  ">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160L0 416c0 53 43 96 96 96l256 0c53 0 96-43 96-96l0-96c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 96c0 17.7-14.3 32-32 32L96 448c-17.7 0-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32l96 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L96 64z"/></svg>
                                    </a>
                                    <div id="tooltip-btn-edit-funeral-schedule-{{ $funeral_schedule_id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip  ">
                                        Update Funeral Schedule Details for {{ $name_of_person }} 
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                <!-- ./ edit-funeral-schedule -->
                            </div>
                            @endif
                        @endif

                        <button
                            @click="showModal = true" type="button"
                            @keydown.window="handleKeydown" 
                            class="py-2 px-3 inline-flex min-w-12 items-center gap-x-2 border-2 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50   "
                            {{-- href="{{ route('schedule.index') }}"> --}}
                            >
                            
                            Search Funeral Schedule

                            <svg class="shrink-0 size-[.8em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="11" cy="11" r="7"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleFullscreen() {
                const el = document.documentElement; // always the whole page
                    if (!document.fullscreenElement) {
                        (el.requestFullscreen || el.webkitRequestFullscreen || el.msRequestFullscreen)?.call(el);
                        setFsState(true);
                    } else {
                        (document.exitFullscreen || document.webkitExitFullscreen || document.msExitFullscreen)?.call(document);
                        setFsState(false);
                    }
            }

            // keep label/state consistent
            // document.addEventListener('fullscreenchange', () => {
            //     setFsState(!!document.fullscreenElement);
            // });
            document.addEventListener('fullscreenchange', () => {
                const isFs = !!document.fullscreenElement;
                document.querySelectorAll('.fullscreen-hide').forEach(el => {
                    el.style.display = isFs ? 'none' : '';
                });
            });

            function setFsState(isFs) {
                const btn = document.getElementById('fsBtn');
                if (!btn) return;
                    btn.title = isFs ? 'Exit fullscreen (F)' : 'Toggle fullscreen (F)';
                    localStorage.setItem('fsActive', isFs ? '1' : '0');
            }

            // restore label after reload
            document.addEventListener('DOMContentLoaded', () => {
                const wasFs = localStorage.getItem('fsActive') === '1';
                setFsState(wasFs && !!document.fullscreenElement); // browsers exit FS on reload
            });

            // keyboard shortcut
            document.addEventListener('keydown', (e) => {
                if (e.key.toLowerCase() === 'f' && !e.metaKey && !e.ctrlKey && !e.altKey) {
                    e.preventDefault();
                    toggleFullscreen();
                }
            });
        </script>
        <!-- ./ fullscreen options -->
        <div class="w-full  ">
            <div class="border border-gray-200 rounded-lg shadow-sm"
                :style="
                        'padding-left: ' + paddingLeft + 'px;' + 
                        'padding-right: ' + paddingRight + 'px;' + 
                        'padding-top: ' + paddingTop + 'px;' + 
                        'padding-bottom: ' + paddingBottom + 'px;' + 

                        'margin-left: ' + marginLeft + 'px;' + 
                        'margin-right: ' + marginRight + 'px;' + 
                        'margin-top: ' + marginTop + 'px;' + 
                        'margin-bottom: ' + marginBottom + 'px;'   

                    "

                >
            
                    
    
                
                <div 
                    x-data="{ 
                        positions: @entangle('positions'),
                        options:  @entangle('options'),
                        addItem(key) {
                            const index = this.positions.indexOf(key);
                            if (index !== -1) this.positions.splice(index, 1); // Remove existing
                            this.positions.push(key); // Add to end
                        }
                    
                    
                    }",
                    
                    class="flex gap-4"
                >
                    



                    <!-- Main Display Area -->
                    <div class="flex-1 space-y-2">
                        <template x-for="(item, index) in positions" :key="index">
                            <div 
                                class="p-4 odd:bg-white even:bg-gray-50 border-gray-200  rounded shadow flex justify-between items-center   text-gray-500 "
                                    
                            >
                                {{-- <span x-text="item.replaceAll('_', ' ').replace(/\b\w/g, l => l.toUpperCase())"></span> --}}

                                <!-- Label -->
                                {{-- <span> --}}
                                    <span 
                                    class="min-w-0 basis-[50%] max-w-[50%] shrink whitespace-normal break-words"
                                    {{-- class="text-[{{ $font_size }}px] text-gray-900 whitespace-nowrap " --}}
                                    :style="`
                                        font-size: ${labelSize}px;
                                        line-height: ${labelLineHeight}px; 
                                        color: ${labelColor};
                                        font-weight: ${labelFontWeight};
                                        letter-spacing: ${labelLetterSpacing}px;
                                        font-style: ${labelFontStyle};
                                    `"
                                    x-text="item.replaceAll('_', ' ').replace(/\b\w/g, l => l.toUpperCase())"></span>: 
                                    
                                {{-- </span> --}}

                                <span 
                                    class="min-w-0 basis-[50%] max-w-[50%] shrink whitespace-normal break-words flex"
                                    {{-- class="flex gap-4" --}}
                                    
                                    >  

                                    <!--
                                        <template x-if="Array.isArray($wire.data[item])">
                                            <div class=" block text-sm   text-end">
                                                <template x-for="line in $wire.data[item]" :key="line">
                                                    <div x-text="line"></div>
                                                </template>
                                            </div>
                                        </template>
                                    -->
                                    {{--  
                                    <!-- Array Handling -->
                                    <template x-if="Array.isArray($wire.data[item])">
                                        <div class="space-y-1 ">
                                            <template x-for="(entry, i) in $wire.data[item]" :key="i">
                                                <div class="grid">
                                                    <!-- family_arrival: time + notes -->
                                                    <template x-if="entry && entry.time && entry.notes">
                                                        <div class="space-x-1">
                                                            <span class="font-semibold text-gray-800" x-text="`${entry.time}:`"></span>
                                                            <span class="italic text-gray-600" x-text="entry.notes"></span>
                                                        </div>
                                                    </template>

                                                    <!-- flowers or equipments: name + notes -->
                                                    <template x-if="entry && entry.name && entry.notes"> 
                                                        <div class="space-x-1">
                                                            <span class="font-semibold text-gray-800" x-text="`${entry.name} - `"></span>
                                                            <span class="italic text-gray-600" x-text="entry.notes"></span>
                                                        </div>
                                                    </template>


                                                    <template x-if="$wire.data.attachments && Object.keys($wire.data.attachments).length">
                                                        <div class="space-y-4">
                                                            <template x-for="[date, files] of Object.entries($wire.data.attachments)" :key="date">
                                                            <div class="border p-2 rounded shadow-sm bg-gray-50">
                                                                <div class="font-semibold text-gray-800 mb-2" x-text="date"></div>

                                                                <ul class="list-disc list-inside text-sm text-gray-700">
                                                                <template x-for="file in files" :key="file.id">
                                                                    <li>
                                                                    <a 
                                                                        class="text-blue-600 hover:underline" 
                                                                        target="_blank" 
                                                                        :href="'/storage/attachments/' + file.attachment"
                                                                        x-text="file.attachment"
                                                                    ></a>
                                                                    </li>
                                                                </template>
                                                                </ul>
                                                            </div>
                                                            </template>
                                                        </div>
                                                    </template>



                                                    <!-- fallback: show name or string -->
                                                    <template x-if="entry && typeof entry === 'object' && !entry.notes && entry.name">
                                                        <div x-text="entry.name"></div>
                                                    </template>

                                                    <!-- fallback primitive -->
                                                    <template x-if="typeof entry !== 'object'">
                                                        <div x-text="entry"></div>
                                                    </template>


                                                    


                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    --}}

                                    <!-- Array Handling -->
                                    <template x-if="Array.isArray($wire.data[item])">
                                        <div class="grid  ">
                                            

                                            

                                            <!-- Attachments Handling -->
                                            <template x-if="item === 'attachments'" class=" ">
                                                
                                                <div class="flex justify-end space-y-1 space-x-1">

                                                
                                                    @auth     
                                                    <div   class="   overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="attachment">
                                                        
                                                        <div class="dz-flex dz-flex-wrap dz-gap-x-10 dz-gap-y-2 dz-justify-start dz-w-full"> 
                                                            <template x-for="(file, i) in $wire.data[item]" :key="i">

                                                                <div class="dz-flex dz-items-center dz-justify-between dz-gap-2 dz-border dz-rounded dz-border-gray-200 dz-w-full">
                                                                    <div class="dz-flex dz-items-center dz-gap-3">
                                                                        
                                                                        <div class="dz-flex dz-justify-center dz-items-center dz-w-14 dz-h-14 dz-bg-gray-100 ">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="dz-w-8 dz-h-8 dz-text-gray-500">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                                            </svg>
                                                                        </div> 
                                                                        <div class="dz-flex dz-flex-col dz-items-start dz-gap-1">
                                                                            <div 
                                                                                {{-- class="dz-text-center dz-text-slate-900 dz-text-sm dz-font-medium" --}}
                                                                                
                                                                                >
                                                                                <span 
                                                                                    {{-- class="italic text-gray-600" --}}
                                                                                    x-text="file.attachment" 
                                                                                    :style="`
                                                                                        font-size: ${valueSize}px;
                                                                                        line-height: ${valueLineHeight}px; 
                                                                                        color: ${valueColor};
                                                                                        font-weight: ${valueFontWeight};
                                                                                        letter-spacing: ${valueLetterSpacing}px;
                                                                                        font-style: ${valueFontStyle};
                                                                                    `"
                                                                                ></span>  
                                                                            </div>
                                                                        </div>

                                                                        
                                                                    </div>
                                                                    
                                                                    <div class="dz-flex dz-items-center dz-mr-3 dz-gap-1">
                                                                        <a     
                                                                            :style="`
                                                                                font-size: ${valueSize}px;
                                                                                line-height: ${valueLineHeight}px; 
                                                                                color: ${valueColor};
                                                                                font-weight: ${valueFontWeight};
                                                                                letter-spacing: ${valueLetterSpacing}px;
                                                                                font-style: ${valueFontStyle};
                                                                            `"
                                                                            :href="file.attachment_file" 
                                                                            :download="file.attachment" 
                                                                            {{-- x-text="file.attachment" --}}
                                                                            class="   bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                                                            
                                                                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                                <path fill="#ffffff" d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                                                            </svg>
                                                                        </a>


                                                                        

                                                                    </div> 
                                                                    

                                                                </div> 
                                                            </template> 
                                                        </div>
                                                    </div>
                                                    @endauth

                                                    @guest
                                                        <div   class="   overflow-hidden transition-[height] duration-300" role="region" aria-labelledby="attachment">
                                                        
                                                            <div class="dz-flex dz-flex-wrap dz-gap-x-10 dz-gap-y-2 dz-justify-start dz-w-full"> 
                                                                <template x-for="(file, i) in $wire.data[item]" :key="i">

                                                                    <div class="dz-flex dz-items-center dz-justify-between dz-gap-2 dz-border dz-rounded dz-border-gray-200 dz-w-full">
                                                                        <div class="dz-flex dz-items-center dz-gap-3">
                                                                            
                                                                            <div class="dz-flex dz-justify-center dz-items-center dz-w-14 dz-h-14 dz-bg-gray-100 ">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="dz-w-8 dz-h-8 dz-text-gray-500">
                                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                                                </svg>
                                                                            </div> 
                                                                            <div class="dz-flex dz-flex-col dz-items-start dz-gap-1">
                                                                                <div class="dz-text-center dz-text-slate-900 dz-text-sm dz-font-medium">
                                                                                    <span 
                                                                                    {{-- class="italic text-gray-600"  --}}
                                                                                    class=" text-gray-600"
                                                                                    x-text="file.attachment"
                                                                                        :style="`
                                                                                            font-size: ${valueSize}px;
                                                                                            line-height: ${valueLineHeight}px; 
                                                                                            color: ${valueColor};
                                                                                            font-weight: ${valueFontWeight};
                                                                                            letter-spacing: ${valueLetterSpacing}px;
                                                                                            font-style: ${valueFontStyle};
                                                                                        `"
                                                                                    ></span>  
                                                                                </div>
                                                                            </div>

                                                                            
                                                                        </div>
                                                                        
                                                                        <div class="dz-flex dz-items-center dz-mr-3 dz-gap-1">
                                                                            <a 
                                                                                href="{{ route('login') }}" 
                                                                                wire:navigate 
                                                                                {{-- x-text="file.attachment" --}}
                                                                                :style="`
                                                                                    font-size: ${valueSize}px;
                                                                                    line-height: ${valueLineHeight}px; 
                                                                                    color: ${valueColor};
                                                                                    font-weight: ${valueFontWeight};
                                                                                    letter-spacing: ${valueLetterSpacing}px;
                                                                                    font-style: ${valueFontStyle};
                                                                                `"
                                                                                class="  bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300">
                                                                                
                                                                                <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                                    <path fill="#ffffff" d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/>
                                                                                </svg>
                                                                            </a>


                                                                            

                                                                        </div> 
                                                                        

                                                                    </div> 
                                                                </template> 
                                                            </div>
                                                        </div>

                                                    @endguest
                                                
                                                </div>  

                                            </template>



                                            <template x-if="item !== 'attachments'">
                                                <template x-for="(entry, i) in $wire.data[item]" :key="i">
                                                    <div class="grid  overflow-auto">
                                                        <!-- family_arrival: time + notes -->
                                                        <template x-if="entry && entry.time && entry.notes">
                                                            <div class="space-x-1"
                                                                
                                                                >
                                                                <span 
                                                                     class=""
                                                                    :style="`
                                                                        font-size: ${valueSize}px;
                                                                        line-height: ${valueLineHeight}px; 
                                                                        color: ${valueColor};
                                                                        font-weight: ${valueFontWeight};
                                                                        letter-spacing: ${valueLetterSpacing}px;
                                                                        font-style: ${valueFontStyle};
                                                                    `"
                                                                    x-text="entry.time + ':'"></span>
                                                                <span 
                                                                    :style="`
                                                                        font-size: ${valueSize}px;
                                                                        line-height: ${valueLineHeight}px; 
                                                                        color: ${valueColor};
                                                                        font-weight: ${valueFontWeight};
                                                                        letter-spacing: ${valueLetterSpacing}px;
                                                                        font-style: ${valueFontStyle};
                                                                    `"
                                                                    x-text="entry.notes"
                                                                ></span>
                                                            </div>
                                                        </template>

                                                        <!-- flowers or equipments: name + notes -->
                                                        <template x-if="entry && entry.name && entry.notes"> 
                                                            <div class="space-x-1"
                                                                
                                                                >   
                                                                <span 
                                                                    :style="`
                                                                        font-size: ${valueSize}px;
                                                                        line-height: ${valueLineHeight}px; 
                                                                        color: ${valueColor};
                                                                        font-weight: ${valueFontWeight};
                                                                        letter-spacing: ${valueLetterSpacing}px;
                                                                        font-style: ${valueFontStyle};
                                                                    `"
                                                                    x-text="entry.name + ' - '"></span>
                                                                <span 
                                                                    :style="`
                                                                        font-size: ${valueSize}px;
                                                                        line-height: ${valueLineHeight}px; 
                                                                        color: ${valueColor};
                                                                        font-weight: ${valueFontWeight};
                                                                        letter-spacing: ${valueLetterSpacing}px;
                                                                        font-style: ${valueFontStyle};
                                                                    `"
                                                                    x-text="entry.notes"></span>
                                                            </div>
                                                        </template>

                                                        <!-- flowers or family point of contact: name + notes -->
                                                        <template x-if="entry && entry.phone && entry.notes"> 
                                                            <div class="space-x-1"
                                                                
                                                                >
                                                                <span 
                                                                    :style="`
                                                                        font-size: ${valueSize}px;
                                                                        line-height: ${valueLineHeight}px; 
                                                                        color: ${valueColor};
                                                                        font-weight: ${valueFontWeight};
                                                                        letter-spacing: ${valueLetterSpacing}px;
                                                                        font-style: ${valueFontStyle};
                                                                    `"
                                                                    x-text="entry.phone + ' - '"></span>
                                                                <span 
                                                                    :style="`
                                                                        font-size: ${valueSize}px;
                                                                        line-height: ${valueLineHeight}px; 
                                                                        color: ${valueColor};
                                                                        font-weight: ${valueFontWeight};
                                                                        letter-spacing: ${valueLetterSpacing}px;
                                                                        font-style: ${valueFontStyle};
                                                                    `"
                                                                    x-text="entry.notes"></span>
                                                            </div>
                                                        </template>

                                                        <!-- fallback: show name or string -->
                                                        <template x-if="entry && typeof entry === 'object' && !entry.notes && entry.name">
                                                            <div 
                                                                :style="`
                                                                    font-size: ${valueSize}px;
                                                                    line-height: ${valueLineHeight}px; 
                                                                    color: ${valueColor};
                                                                    font-weight: ${valueFontWeight};
                                                                    letter-spacing: ${valueLetterSpacing}px;
                                                                    font-style: ${valueFontStyle};
                                                                `"
                                                                x-text="entry.name"></div>
                                                        </template>

                                                        <!-- fallback primitive -->
                                                        <template x-if="typeof entry !== 'object'">
                                                            <div
                                                                :style="`
                                                                    font-size: ${valueSize}px;
                                                                    line-height: ${valueLineHeight}px; 
                                                                    color: ${valueColor};
                                                                    font-weight: ${valueFontWeight};
                                                                    letter-spacing: ${valueLetterSpacing}px;
                                                                    font-style: ${valueFontStyle};
                                                                `"
                                                                x-text="entry"
                                                                ></div>
                                                        </template>
                                                    </div>
                                                </template>
                                            </template>
                                        </div>
                                    </template>







                                    <template x-if="!Array.isArray($wire.data[item])"> 
                                        <span class="" x-text="$wire.data[item] ?? '—'" 
                                            {{-- style="font-size: {{ $font_size }}px; font-weight: bold;" --}}
                                            :style="`
                                                font-size: ${valueSize}px;
                                                line-height: ${valueLineHeight}px; 
                                                color: ${valueColor};
                                                font-weight: ${valueFontWeight};
                                                letter-spacing: ${valueLetterSpacing}px;
                                                font-style: ${valueFontStyle};
                                            `"
                                        ></span>
                                        

                                        {{-- <div class="space-x-1">
                                            <span class="font-semibold text-gray-800" x-text="entry.time + ':'"></span>
                                            <span class="italic text-gray-600" x-text="entry.notes"></span>
                                        </div> --}}

                                    </template>
                                        

                                </span>
                                
                            </div>


                            {{-- <template x-if="Array.isArray($wire.data[item])">
                                <div class="whitespace-pre-line text-sm text-gray-700">
                                    <template x-for="line in $wire.data[item]" :key="line">
                                        <div x-text="line"></div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!Array.isArray($wire.data[item])">
                                <span x-text="$wire.data[item] ?? '—'"></span>
                            </template> --}}


                        </template>

                            
                    </div>

                </div>

                
    
                
            </div>
        </div>
    </div>





     <!-- Schedule modal-->
    @teleport('body')
        <div x-show="showModal"   x-trap="showModal" class="relative z-10 " aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10"> -->
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto py-10">
                <div class="flex justify-center p-4 sm:p-0">
                    <div
                        class="relative transform overflow-x-hidden overflow-y-visible rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div 
                            {{-- @click.outside="showModal = false" --}}
                            
                            class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4  min-h-96">
                            <div class="w-full px-1 pt-1" x-data="{
                                searchPosts(event) {
                                    document.getElementById('searchInput').focus();
                                    event.preventDefault();
                                }
                            }">
                                <form action="" autocomplete="off">
                                    <input
                                    autocomplete="off"
                                    wire:model.live.throttle.500ms="schedule_search" type="text" id="searchInput"
                                    name="searchInput"
                                    class="block w-full flex-1 py-2 px-3 mt-2 outline-none border-none rounded-md bg-slate-100"
                                    placeholder="Search for funeral details ..." @keydown.slash.window="searchPosts" />


                                    <div class="flex justify-between my-1">
                                        <div x-data="{ dateRange: @entangle('date_range') }" class="mb-4">
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
                                                class="bg-white border border-gray-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 w-full"
                                                placeholder="Select date range"
                                            >
                                        </div>

                                        <div>
                                            <button id="schedule-filter-dropdownRadioButton" data-dropdown-toggle="schedule-filter-dropdownRadio" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200" type="button">
                                                {{ !empty($filter_by) ? $filter_by : 'Show Schedules for ' }}
                                                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                                </svg>
                                            </button>
                                            <!-- Dropdown menu -->
                                            <div id="schedule-filter-dropdownRadio" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow-sm " data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate3d(522.5px, 3847.5px, 0px);">
                                                <ul class="p-3 space-y-1 text-sm text-gray-700 z-40" aria-labelledby="schedule-filter-dropdownRadioButton">
                                                    @foreach ($schedule_filters as $schedule_filter)
                                                        <li>
                                                            <div class="flex items-center p-2 rounded-sm hover:bg-gray-100 ">
                                                                <input 
                                                                wire:model.live="filter_by"
                                                                id="sort-{{ Str::slug($schedule_filter) }}" 
                                                                type="radio" 
                                                                value="{{ $schedule_filter }}" 
                                                                name="selected_schedule_filter" 
                                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500   focus:ring-2 ">
                                                                <label for="sort-{{ Str::slug($schedule_filter) }}" class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm ">{{ $schedule_filter }}</label>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                                            
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


                                        <div>
                                            <button
                                                @click="showModal = false" type="button"
                                                @keydown.window="handleKeydown" 
                                                class="py-2 px-3 inline-flex min-w-12 items-center gap-x-2 border-2 border-gray-200 rounded-lg text-sm bg-red-500 text-white focus:border-red-500 focus:ring-red-500 disabled:opacity-50   "
                                                {{-- href="{{ route('schedule.index') }}"> --}}
                                                >
                                                
                                                Close 

                                                
                                            </button>
                                        </div>

                                    </div>

                                </form>
                                <div class="mt-2 w-full overflow-hidden rounded-md bg-white">

                                    
                                        @if(!empty($results) && count($results) > 0)
                                            <div class=" py-2 px-3 border-b border-slate-200 text-sm font-medium text-slate-500">

                                                All Projects <strong>(Click to select a project)</strong>

                                            </div>

                                            @foreach ($results as $result)
                                                {{-- <div class="cursor-pointer py-2 px-3 hover:bg-slate-100 bg-white border border-gray-200 shadow-sm rounded-xl mb-1"
                                                wire:click="search('{{  $result->id }}')"
                                                @click="showModal = false"
                                                >
                                                    <p class="text-sm font-medium text-gray-600 cursor-pointer flex items-center gap-3">
                                                        

                                                        <div class="max-w-full text-wrap ">
                                                            <div class="px-2 py-2   text-wrap">
                                                                  
                                                                <span class="text-sm text-gray-600 ">
                                                                    <strong>{{ $result->name_of_person }}</strong>
                                                                    <hr> 
                                                                    {{ $result->burial_cemetery }}
                                                                    <hr>
                                                                    {{ $result->burial_location }}
                                                                </span> 
  
                                                            </div>
                                                        </div>

                                                        

                                                        <div class="max-w-full size-auto whitespace-nowrap  ">
                                                            <div class="px-2 py-2   max-h-52 text-wrap overflow-auto">
                                                                <span class="text-sm text-gray-600  ">
                                                                    {{ $result->description ? $result->description : '' }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                    </p>
                                                </div> --}}

                                                <a class="block cursor-pointer py-2 px-3 hover:bg-slate-100 bg-white border border-gray-200 shadow-sm rounded-xl mb-1"
                                                {{-- wire:click="search('{{  $result->id }}')"
                                                @click="showModal = false" --}}

                                               href="{{ route('funeral_schedule.public.show',['funeral_schedule' => $result->id]) }}"  
                                                wire:navigate
                                                >
                                                    <p class="text-sm font-medium text-gray-600 cursor-pointer flex items-center gap-3">
                                                        

                                                        <div class="max-w-full text-wrap ">
                                                            <div class="px-2 py-2   text-wrap">
                                                                  
                                                                <span class="text-sm text-gray-600 ">
                                                                    <strong>{{ $result->name_of_person }}</strong>
                                                                    <hr>
                                                                    <strong>DATE: </strong> {{ $result->date ? optional($result->date)->format('M d Y') : '' }}
                                                                    <hr> 
                                                                    {{ $result->burial_cemetery }}
                                                                    <hr>
                                                                    {{ $result->burial_location }}
                                                                </span> 
  
                                                            </div>
                                                        </div>

                                                        

                                                        <div class="max-w-full size-auto whitespace-nowrap  ">
                                                            <div class="px-2 py-2   max-h-52 text-wrap overflow-auto">
                                                                <span class="text-sm text-gray-600  ">
                                                                    {{ $result->date ? $result->description : '' }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                    </p>
                                                </a>
                                            @endforeach

                                        @else
                                            <div class=" py-2 px-3 border-b border-slate-200 text-sm font-medium text-slate-500">

                                                <div class="mb-2 bg-red-50 border-s-4 border-red-500 p-4 " role="alert" tabindex="-1" aria-labelledby="hs-bordered-red-style-label">
                                                    <div class="flex">
                                                        <div class="shrink-0">
                                                            <!-- Icon -->
                                                            <span class="inline-flex justify-center items-center size-8 rounded-full border-4 border-red-100 bg-red-200 text-red-800 ">
                                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                    <path d="M18 6 6 18"></path>
                                                                    <path d="m6 6 12 12"></path>
                                                                </svg>
                                                            </span>
                                                            <!-- End Icon -->
                                                        </div>
                                                        <div class="ms-3">
                                                            <h3 id="hs-bordered-red-style-label" class="text-gray-800 font-semibold ">
                                                               Funeral schedule not found
                                                            </h3>
                                                            <p class="text-sm text-gray-700 ">

                                                               Search for name, description, agency or related data
                                                            </p>
                                                        </div>



                                                    </div>
                                                </div>



                                            </div>
                                        @endif

    

                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    @endteleport
    <!-- ./ Schedule modal-->




    @push('scripts')
        {{-- <script>
            // Listen for fullscreen change
            document.addEventListener('fullscreenchange', toggleFullscreenDiv);
            document.addEventListener('webkitfullscreenchange', toggleFullscreenDiv); // Safari
            document.addEventListener('msfullscreenchange', toggleFullscreenDiv); // IE11

            function toggleFullscreenDiv() {
                const container = document.getElementById('fullscreenContainer');
                if (document.fullscreenElement) {
                    container.classList.add('hidden'); // Hide div
                } else {
                    container.classList.remove('hidden'); // Show div
                }
            }
        </script> --}}
    @endpush
</section>