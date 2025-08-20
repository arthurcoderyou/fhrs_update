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

        

    }"


    >
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

    <div wire:loading
        class="fixed inset-0     z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div  >
        {{-- <div class=" mx-auto max-w-full bg-white px-6 py-2  border border-gray-200 rounded-lg shadow-sm  ">
            <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl  flex align-middle space-x-4"> 
                Update Display Screen
            </h2>
            <p class="text-sm text-gray-500 mb-2">
                The preview below is how will it be displayed to the display screen
            </p>  

            <div class="  ">

                    
                <!-- styles init and toggle --> 
                <button class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5  focus:outline-none " 
                    type="button" 
                    data-drawer-target="styles-drawer" 
                    data-drawer-show="styles-drawer" 
                    data-fields-drawer="true" 
                    data-drawer-backdrop="false"
                    aria-controls="styles-drawer">
                    Styles
                </button> 

                <!-- drawer init and toggle --> 
                <button class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5   focus:outline-none " 
                    type="button" 
                    data-drawer-target="fields-drawer" 
                    data-drawer-show="fields-drawer" 
                    data-fields-drawer="true" 
                    data-drawer-backdrop="false"
                    aria-controls="fields-drawer">
                    Add Fields
                </button> 

                <button 
                type="button" 
                wire:click="save"
                wire:confirm="Are you sure?"
                class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                    Save
                </button>

                

            </div>

        </div> --}}


        <!-- fullscreen options -->
        <div
        id="fullscreenContainer"
        class="sticky top-0 z-30 bg-white/70  backdrop-blur supports-[backdrop-filter]:border-b border-gray-200/60 text-start"
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
                        href="{{ route('welcome') }}" wire:navigate
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



                        <!-- Styles (drawer opener) -->
                        <button
                        type="button"
                        class="group inline-flex items-center gap-2 rounded-xl border border-gray-200  bg-white px-3 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-gray-700  shadow-sm hover:bg-gray-50  focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/70 active:scale-[.99] transition"
                        title="Open styles"
                        aria-label="Open styles"
                        aria-controls="styles-drawer"
                        data-drawer-target="styles-drawer"
                        data-drawer-show="styles-drawer"
                        data-fields-drawer="true"
                        data-drawer-backdrop="false"
                        data-tooltip-target="tooltip-styles-drawer"
                        >
                            <!-- Sliders icon -->
                            <svg class="size-4 sm:size-5 shrink-0" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <!-- row 1 -->
                                <line x1="4" y1="6" x2="20" y2="6"/>
                                <circle cx="9" cy="6" r="2" fill="currentColor" stroke="none"/>
                                <!-- row 2 -->
                                <line x1="4" y1="12" x2="20" y2="12"/>
                                <circle cx="15" cy="12" r="2" fill="currentColor" stroke="none"/>
                                <!-- row 3 -->
                                <line x1="4" y1="18" x2="20" y2="18"/>
                                <circle cx="7" cy="18" r="2" fill="currentColor" stroke="none"/>
                            </svg>
                            <span class="sr-only">Styles</span>

                            <div id="tooltip-styles-drawer" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip  ">
                                Click to Add Styles
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </button>


                         <!-- drawer init and toggle --> 
                        <button class="group inline-flex items-center gap-2 rounded-xl border border-gray-200  bg-white px-3 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-gray-700  shadow-sm hover:bg-gray-50  focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/70 active:scale-[.99] transition " 
                            type="button" 
                            data-drawer-target="fields-drawer" 
                            data-drawer-show="fields-drawer" 
                            data-fields-drawer="true" 
                            data-drawer-backdrop="false"
                            aria-controls="fields-drawer"
                            data-tooltip-target="tooltip-add-fields"
                            >
                            Add Fields

                            <div id="tooltip-add-fields" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip  ">
                                Click to Add Fields
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>

                        </button> 

                        <button 
                        type="button" 
                        wire:click="save"
                        wire:confirm="Are you sure?"
                        class="group inline-flex items-center gap-2 rounded-xl border border-gray-200  bg-white px-3 py-2 sm:px-4 sm:py-2.5 text-xs sm:text-sm font-medium text-gray-700  shadow-sm hover:bg-gray-50  focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500/70 active:scale-[.99] transition "
                            data-tooltip-target="tooltip-save"
                            >
                            Save
                            <div id="tooltip-save" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip  ">
                                Click to Save Design
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </button>


                    </div>
                </div>
            </div>
        </div>

        <!-- styles-drawer component -->
            <!-- drawer component -->
            {{-- <div id="styles-drawer" class="fixed top-0 left-0 right-0 z-40 w-full p-4 transition-transform -translate-y-full bg-white " tabindex="-1" aria-labelledby="drawer-top-label"> --}}
            {{-- <div id="styles-drawer"
            class="fixed top-0 left-0 z-40 h-screen w-64 p-4 transition-transform -translate-x-full bg-white"
            tabindex="-1" aria-labelledby="drawer-left-label"> --}}
            <div id="styles-drawer"
            class="fixed top-0 left-0 z-40 h-dvh w-64 p-4 transition-transform -translate-x-full
            bg-white overflow-y-auto overscroll-contain"
            style="-webkit-overflow-scrolling: touch;"  
            tabindex="-1" aria-labelledby="drawer-left-label">


                <h5 id="drawer-top-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 ">
                    <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>Display Styles
                
                </h5>

                <button type="button" data-drawer-hide="styles-drawer" aria-controls="styles-drawer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 flex items-center justify-center " >
                    <svg class="w-3 h-3 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close menu</span>
                </button>
                

                

                <!-- Accordion: Tailwind + Alpine -->
                <div
                x-data="{
                    open: { card: true, label: false, value: false },
                    all(state){ this.open.card = state; this.open.label = state; this.open.value = state; }
                }"
                class="space-y-3"
                >

                    <!-- Toolbar -->
                    <div class="flex items-center justify-end gap-2">
                        <button type="button"
                        @click="all(true)"
                        class="inline-flex items-center rounded-lg border px-3 py-1.5 text-sm shadow-sm hover:bg-gray-50">
                        Expand all
                        </button>
                        <button type="button"
                        @click="all(false)"
                        class="inline-flex items-center rounded-lg border px-3 py-1.5 text-sm shadow-sm hover:bg-gray-50">
                        Collapse all
                        </button>
                    </div>

                    <!-- Panel: Card -->
                    <section class="rounded-xl border bg-white shadow-sm">
                        <button type="button"
                        class="flex w-full items-center justify-between px-4 py-3"
                        @click="open.card = !open.card"
                        :aria-expanded="open.card"
                        >
                        <span class="text-sm font-semibold text-gray-900">Card Styles</span>
                        <svg class="size-5 transition-transform" :class="open.card ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                        </svg>
                        </button>

                        <div x-show="open.card" x-collapse>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 px-4 pb-4">
                            <div>
                            <label for="paddingLeft" class="block text-sm font-medium text-gray-900">Card Padding Left (px):</label>
                            <input type="number" id="paddingLeft" x-model="paddingLeft" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <div>
                            <label for="paddingRight" class="block text-sm font-medium text-gray-900">Card Padding Right (px):</label>
                            <input type="number" id="paddingRight" x-model="paddingRight" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <div>
                            <label for="paddingTop" class="block text-sm font-medium text-gray-900">Card Padding Top (px):</label>
                            <input type="number" id="paddingTop" x-model="paddingTop" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <div>
                            <label for="paddingBottom" class="block text-sm font-medium text-gray-900">Card Padding Bottom (px):</label>
                            <input type="number" id="paddingBottom" x-model="paddingBottom" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <div>
                            <label for="marginLeft" class="block text-sm font-medium text-gray-900">Card Margin Left (px):</label>
                            <input type="number" id="marginLeft" x-model="marginLeft" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <div>
                            <label for="marginRight" class="block text-sm font-medium text-gray-900">Card Margin Right (px):</label>
                            <input type="number" id="marginRight" x-model="marginRight" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <div>
                            <label for="marginTop" class="block text-sm font-medium text-gray-900">Card Margin Top (px):</label>
                            <input type="number" id="marginTop" x-model="marginTop" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <div>
                            <label for="marginBottom" class="block text-sm font-medium text-gray-900">Card Margin Bottom (px):</label>
                            <input type="number" id="marginBottom" x-model="marginBottom" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>
                        </div>
                        </div>
                    </section>

                    <!-- Panel: Label -->
                    <section class="rounded-xl border bg-white shadow-sm">
                        <button type="button"
                        class="flex w-full items-center justify-between px-4 py-3"
                        @click="open.label = !open.label"
                        :aria-expanded="open.label"
                        >
                        <span class="text-sm font-semibold text-gray-900">Label Styles</span>
                        <svg class="size-5 transition-transform" :class="open.label ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                        </svg>
                        </button>

                        <div x-show="open.label" x-collapse>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 px-4 pb-4">
                            <!-- Size -->
                            <div>
                                <label for="labelSize" class="block text-sm font-medium text-gray-900">Label Size (px):</label>
                                <input type="number" id="labelSize" x-model.number="labelSize" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <!-- Line height -->
                            <div>
                                <label for="labelLineHeight" class="block text-sm font-medium text-gray-900">Label Line Height (px):</label>
                                <input type="number" id="labelLineHeight" x-model.number="labelLineHeight" min="10" max="100"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <!-- Color -->
                            <div class="flex items-end gap-2">
                                <div class="grow">
                                <label for="labelColor" class="block text-sm font-medium text-gray-900">Label Color:</label>
                                <input type="text" id="labelColor" x-model="labelColor" placeholder="#000000"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                </div>
                                <input type="color" x-model="labelColor" class="h-10 w-10 border rounded" />
                            </div>

                            <!-- Font style -->
                            <div>
                            <label for="labelFontStyle" class="block text-sm font-medium text-gray-900">Font Style:</label>
                            <select id="labelFontStyle" x-model="labelFontStyle"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                            focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="normal">Normal</option>
                                <option value="italic">Italic</option>
                            </select>
                            </div>

                            <!-- Font weight -->
                            <div>
                            <label for="labelFontWeight" class="block text-sm font-medium text-gray-900">Font Weight:</label>
                            <select id="labelFontWeight" x-model="labelFontWeight"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                            focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="normal">Normal</option>
                                <option value="bold">Bold</option>
                                <option value="bolder">Bolder</option>
                                <option value="100">Thin (100)</option>
                                <option value="200">Extra Light (200)</option>
                                <option value="300">Light (300)</option>
                                <option value="400">Normal (400)</option>
                                <option value="500">Medium (500)</option>
                                <option value="600">Semi Bold (600)</option>
                                <option value="700">Bold (700)</option>
                                <option value="800">Extra Bold (800)</option>
                                <option value="900">Black (900)</option>
                            </select>
                            </div>

                            <!-- Letter spacing -->
                            <div>
                                <label for="labelLetterSpacing" class="block text-sm font-medium text-gray-900">Letter Spacing (px):</label>
                                <input type="number" id="labelLetterSpacing" x-model.number="labelLetterSpacing" step="0.1" min="0" max="10"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>
                        </div>
                        </div>
                    </section>

                    <!-- Panel: Value -->
                    <section class="rounded-xl border bg-white shadow-sm">
                        <button type="button"
                        class="flex w-full items-center justify-between px-4 py-3"
                        @click="open.value = !open.value"
                        :aria-expanded="open.value"
                        >
                        <span class="text-sm font-semibold text-gray-900">Value Styles</span>
                        <svg class="size-5 transition-transform" :class="open.value ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />
                        </svg>
                        </button>

                        <div x-show="open.value" x-collapse>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 px-4 pb-4">
                            <div>
                                <label for="valueSize" class="block text-sm font-medium text-gray-900">Value Size (px):</label>
                                <input type="number" id="valueSize" x-model="valueSize" min="10" max="100"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>

                            <div>
                                <label for="valueLineHeight" class="block text-sm font-medium text-gray-900">Value Line Height (px):</label>
                                <input type="number" id="valueLineHeight" x-model="valueLineHeight" min="10" max="100"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>


                            <!-- Color -->
                            <div class="flex items-end gap-2">
                                <div class="grow">
                                <label for="valueColor" class="block text-sm font-medium text-gray-900">Value Color:</label>
                                <input type="text" id="valueColor" x-model="valueColor" placeholder="#000000"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                </div>
                                <input type="color" x-model="valueColor" class="h-10 w-10 border rounded" />
                            </div>

                            <!-- Font style -->
                            <div>
                            <label for="valueFontStyle" class="block text-sm font-medium text-gray-900">Font Style:</label>
                            <select id="valueFontStyle" x-model="valueFontStyle"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                            focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="normal">Normal</option>
                                <option value="italic">Italic</option>
                            </select>
                            </div>

                            <!-- Font weight -->
                            <div>
                            <label for="valueFontWeight" class="block text-sm font-medium text-gray-900">Font Weight:</label>
                            <select id="valueFontWeight" x-model="valueFontWeight"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                                            focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                <option value="normal">Normal</option>
                                <option value="bold">Bold</option>
                                <option value="bolder">Bolder</option>
                                <option value="100">Thin (100)</option>
                                <option value="200">Extra Light (200)</option>
                                <option value="300">Light (300)</option>
                                <option value="400">Normal (400)</option>
                                <option value="500">Medium (500)</option>
                                <option value="600">Semi Bold (600)</option>
                                <option value="700">Bold (700)</option>
                                <option value="800">Extra Bold (800)</option>
                                <option value="900">Black (900)</option>
                            </select>
                            </div>

                            <!-- Letter spacing -->
                            <div>
                                <label for="valueLetterSpacing" class="block text-sm font-medium text-gray-900">Letter Spacing (px):</label>
                                <input type="number" id="valueLetterSpacing" x-model.number="valueLetterSpacing" step="0.1" min="0" max="10"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                            </div>





                        </div>
                        </div>
                    </section>
                </div>



            </div>


            <!-- drawer component -->
            <div id="fields-drawer" class="fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-80 " tabindex="-1" aria-labelledby="drawer-label">
                <h5 id="drawer-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-500 ">
                    <svg class="w-4 h-4 me-2.5  " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>Add Fields
                </h5>

                

                <button type="button" data-drawer-hide="fields-drawer" aria-controls="fields-drawer" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 flex items-center justify-center " >
                    <svg class="w-3 h-3 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close menu</span>
                </button>
                    
                <p class="max-w-lg mb-6 text-sm text-gray-500 ">
                    ✅ Means that the field is already added to the display
                </p>



                <template x-for="opt in options" :key="opt" class="grid grid-cols-1 ">
                    <button 
                        class="block w-full mb-2 px-4 py-2 text-sm font-medium text-start text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 "
                        @click="addItem(opt)"
                    >
                        <i class="fas fa-plus mr-2 "></i>
                        <span x-text="opt.replaceAll('_', ' ').replace(/\b\w/g, l => l.toUpperCase())"></span>

                        <!-- Checkmark if already added -->
                        <span 
                            class=" "
                            x-show="positions.includes(opt)"
                        >
                            ✅
                        </span>

                    </button>
                </template>

            </div>
        <!-- ./ styles-drawer component -->


        {{-- <hr class="h-px my-8 bg-gray-200 border-0 "> --}}


        <div 
            class="w-full  "
            >

            

            <!-- Card -->
                <div 
                class="border border-gray-200 rounded-lg shadow-sm"

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
                            

                        <!-- Main Draggable Area -->
                        <div class=" flex-1 space-y-1  "

                        
                        >

                            <!-- Items -->
                            <template x-for="(item, index) in positions" :key="index">

                                <!-- Item   -->
                                <div 
                                    class="p-4 odd:bg-white even:bg-gray-50 border-gray-200  rounded shadow flex justify-between items-center cursor-move  text-sm  text-gray-500 "
                                    draggable="true"
                                    @dragstart="event.dataTransfer.setData('text/plain', index)"
                                    @dragover.prevent
                                    @drop="
                                        let from = event.dataTransfer.getData('text/plain'); 
                                        let to = index;
                                        positions.splice(to, 0, positions.splice(from, 1)[0])
                                    "
                                >
                                        

                                    <!-- Label -->
                                    
                                        <span class=" " x-text="item.replaceAll('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) + ':'"  
                                        :style="`
                                            font-size: ${labelSize}px;
                                            line-height: ${labelLineHeight}px; 
                                            color: ${labelColor};
                                            font-weight: ${labelFontWeight};
                                            letter-spacing: ${labelLetterSpacing}px;
                                            font-style: ${labelFontStyle};
                                        `"
                                        ></span>  
                                    
                                        
                                    <!-- ./ Label -->


                                    <!-- Value and Remove Button -->
                                        <span class="flex gap-4">  
                                            <!-- Value Text -->
                                                <!-- Array Value -->
                                                    <template x-if="Array.isArray($wire.data[item])">
                                                        <div class="  ">
                                                            <template 
                                                                x-for="line in $wire.data[item]" 
                                                                :key="line"
                                                                
                                                                >
                                                                <div x-text="line"
                                                                :style="`
                                                                    font-size: ${valueSize}px;
                                                                    line-height: ${valueLineHeight}px; 
                                                                    color: ${valueColor};
                                                                    font-weight: ${valueFontWeight};
                                                                    letter-spacing: ${valueLetterSpacing}px;
                                                                    font-style: ${valueFontStyle};
                                                                `"
                                                                ></div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                <!-- ./ Array Value -->

                                                <!-- Single Value -->
                                                    <template x-if="!Array.isArray($wire.data[item])">
                                                        <span
                                                        x-text="$wire.data[item] ?? '—'"
                                                        :style="`
                                                            font-size: ${valueSize}px;
                                                            line-height: ${valueLineHeight}px; 
                                                            color: ${valueColor};
                                                            font-weight: ${valueFontWeight};
                                                            letter-spacing: ${valueLetterSpacing}px;
                                                            font-style: ${valueFontStyle};
                                                        `"
                                                        ></span>
                                                    </template>
                                                <!-- ./ Single Value -->

                                            <!-- ./ Value Text -->

                                            <!-- Remove Button -->
                                            <button 
                                                    class="ml-4 text-red-500 hover:text-red-700 font-bold"
                                                    @click="positions.splice(index, 1)"
                                                    title="Remove"
                                                >
                                                ✕
                                            </button>
                                            <!-- ./ Remove Button -->

                                        </span>
                                    <!-- ./ Value and Remove Button  -->
                                    
                                </div>
                                <!-- ./ Item -->


                            </template>

                            <div class="mt-4">

                                <x-input-error :messages="$errors->get('error')" class="my-1" />

                            </div>
                        </div>

                        <!-- ./ Main Draggable Area -->



        
                    </div> 
                </div> 
            <!-- ./ Card -->



        </div>
    </div>
     

    
    @push('scripts')

        <script>
        // Toggle fullscreen for #fullscreenContainer; falls back to documentElement
        function toggleFullscreen() {
            const target = document.getElementById('fullscreenContainer') || document.documentElement;
            if (!document.fullscreenElement) {
            (target.requestFullscreen || target.webkitRequestFullscreen || target.msRequestFullscreen)?.call(target);
            updateFsLabel(true);
            } else {
            (document.exitFullscreen || document.webkitExitFullscreen || document.msExitFullscreen)?.call(document);
            updateFsLabel(false);
            }
        }

        // Update button label on change (optional, keeps text accurate if user presses ESC)
        document.addEventListener('fullscreenchange', () => {
            updateFsLabel(!!document.fullscreenElement);
        });

        function updateFsLabel(isFs) {
            const btn = document.getElementById('fsBtn');
            if (!btn) return;
            btn.title = isFs ? 'Exit fullscreen (F)' : 'Toggle fullscreen (F)';
            // You could also swap the icon here if you want an “exit fullscreen” glyph
        }

        // Keyboard shortcut: press "F" to toggle
        document.addEventListener('keydown', (e) => {
            if (e.key.toLowerCase() === 'f' && !e.metaKey && !e.ctrlKey && !e.altKey) {
            e.preventDefault();
            toggleFullscreen();
            }
        });
        </script>
        <!-- ./ fullscreen options -->

        <script>
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
        </script>
    @endpush


</section>
