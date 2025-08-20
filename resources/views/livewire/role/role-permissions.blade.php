<section class=" py-4 antialiased   ">
    <div wire:loading
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <span class="loader"></span>
    </div>

    <div class="mx-auto max-w-6xl bg-white    p-6  border border-gray-200 rounded-lg shadow-sm  ">
        <div class=" mx-auto ">
            <div class="gap-4 sm:flex sm:items-center sm:justify-between overflow-auto ">
                <h2 class="text-xl font-semibold text-gray-900  sm:text-2xl">Update Role "{{ $role->name }}" Permissions Details</h2>
            </div>
            <!-- Modal content -->
            <div class="relative  py-2  rounded-lg   ">
                 
                <!-- Modal body -->
                <form wire:submit="save">
                    


                    <div class="  mx-auto max-w-screen-2xl my-4">
                        <div class="relative overflow-visible bg-white shadow-md  sm:rounded-lg">
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left text-gray-500 ">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                                         

                                        <tr>
                                            
                                            <th scope="col" class="px-4 py-3">Module</th>  
                                            <th scope="col" class="px-4 py-3">
                                                <div class="flex items-center gap-x-2 justify-between">
                                                    <div>
                                                        Permissions
                                                    </div>
                                                    <div class="flex items-center gap-x-2">
                                                        <input 
                                                        id="checkbox-all" 
                                                        type="checkbox" 
                                                        wire:click="selectAll($event.target.checked)"
                                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 ">
                                                        <label for="checkbox-all" class="sr-only">checkbox</label>

                                                        <div>
                                                            Select All
                                                        </div>
                                                        

                                                    </div>
                                                </div>
                                            </th>   
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($module_permissions))
                                            @foreach ($module_permissions as $module => $module_permission_options)
                                                @if($module == "Permissions" && !Auth::user()->hasRole('Global Administrator'))
                                                    <!-- Show nothing -->
                                                @else

                                                    <tr class="border-b  hover:bg-gray-100 ">
                                                        
                                                        <td class="w-4 px-4 py-3">
                                                            {{ $module }}
                                                        </td>
                                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap max-w-[20rem] text-wrap overflow-x-auto">
                                                            <div class="px-2 py-2">
                                                                <div class="grid sm:grid-cols-4 gap-2">
                        
                                                                    @if(!empty($module_permission_options) && count($module_permission_options) > 0)
                                                                        @foreach ($module_permission_options as $permission)
                                                                            <label for="{{ $permission->name }}" class="flex p-3 w-full bg-white border border-sky-500 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500   ">
                                                                                <span class="text-sm text-black ">{{ $permission->name }}</span>
                                                                                <input wire:model="selected_permissions" type="checkbox" value="{{ $permission->id }}" class="shrink-0 ms-auto mt-0.5 border-sky-500 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none  " id="{{ $permission->name }}">
                                                                            </label>
                                                                        @endforeach
                                                                    @endif
                        
                                                                </div>
                                                            </div>
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                @endif
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
                             
                        </div>
                    </div>


                    <div class="mb-4">
                        <x-input-error :messages="$errors->get('selected_permissions')" class="mt-2" />
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
