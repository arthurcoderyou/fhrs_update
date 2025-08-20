<section class=" py-4 antialiased   ">
    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <div class="gap-4 sm:flex sm:items-center sm:justify-between overflow-auto ">
                <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl">Create Role</h2>
            </div>
            <!-- Modal content -->
            <div class="relative  py-2  rounded-lg   ">
                 
                <!-- Modal body -->
                <form wire:submit="save">
                    <div class=" gap-4 mb-4 grid  ">
                        <div class="grid grid-cols-1    gap-y-2 sm:gap-y-0 gap-x-2  ">

                            <div class="w-full ">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Name</label>
                                <input type="text" 
                                name="name" 
                                id="name" 
                                wire:model="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 " 
                                
                                >
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                             
                        </div>
                         
                    </div>
                    <button 
                    type="button" 
                    wire:click="save"
                    wire:confirm="Are you sure?"
                    class="text-white inline-flex items-center bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Save
                    </button>
                    <a href="{{ route('role.index') }}" 
                    wire:navigate
                    class="text-white inline-flex items-center bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        Cancel
                    </a>
                </form>
            </div> 
        </div> 
    </div>
</section>
