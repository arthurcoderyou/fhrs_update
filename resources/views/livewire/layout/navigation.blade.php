<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>
{{--   
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
      <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>


            @auth

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <button wire:click="logout" class="w-full text-start">
                                <x-dropdown-link>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </button>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            @endauth

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>


        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </button>
                </div>
            </div>
        @endauth



    </div>  
</nav>
--}}

<nav
 x-data="{ open: false }" 
 class="bg-white border-b border-gray-100">
    
  

  <nav class="bg-white border-gray-200 fixed w-full z-20 top-0 start-0 ">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="{{ route('welcome') }}" wire:navigate class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="{{ asset('images/bird.jpg') }}" class="h-8" alt="FHRS Logo" />
        <span class="self-center text-2xl font-semibold whitespace-nowrap " data-tooltip-target="tooltip-fhrs" >FH<span class="text-sky-500">RS</span> </span> 
        <div id="tooltip-fhrs" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip ">
          Funeral Homes Reservation Management 
          <div class="tooltip-arrow" data-popper-arrow></div>
        </div>


      </a>
      <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

        @auth
          <button type="button" class="flex text-sm bg-gray-800 rounded-full ring-4 ring-sky-200 md:me-0 focus:ring-4 focus:ring-gray-300 " id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
            <span class="sr-only">Open user menu</span>
            <img class="w-8 h-8 rounded-full" src="{{ asset('images/user.jpg') }}" alt="user photo">
            {{-- <i class="w-8 h-8 fa-thin fa-circle-user" style="color: #74C0FC;"></i> --}}
          </button>
          <!-- Dropdown menu -->
          <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm " id="user-dropdown">
            <div class="px-4 py-3">
              <span class="block text-sm text-gray-900 ">{{ auth()->user()->name }}</span>
              <span class="block text-sm  text-gray-500 truncate ">{{ auth()->user()->email }}</span>
            </div>
            <ul class="py-2" aria-labelledby="user-menu-button">
              <li>
                <a href="{{ route('dashboard') }}" wire:navigate class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ">Dashboard</a>
              </li>
              <li>
                <a href="{{ route('profile') }}" wire:navigate class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ">Profile</a>
              </li> 
              <li>
                <button wire:click="logout" type="button" class="block w-full text-start px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 ">Sign out</button>
              </li>
            </ul>
          </div>
        @endauth
  
        @guest
          <a href="{{ route('login') }}" wire:navigate class="text-gray-800  hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 ">Log in</a>
          <a href="{{ route('register') }}" wire:navigate class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2  focus:outline-none ">Sign Up</a>
        @endguest

        <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 " aria-controls="navbar-user" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
        </button>
      </div>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
        <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white ">
          <li>
            {{-- <a href="#" class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 " aria-current="page">Home</a> --}}
            <x-flowbite-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
              {{ __('Dashboard') }}
            </x-flowbite-nav-link>
          </li>

          {{-- <li>
            
            <x-flowbite-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')" wire:navigate>
              {{ __('Users') }}
            </x-flowbite-nav-link>
          </li> --}}


          <li>

            <!-- Check if system is active-->
            @php
                // $active = "bg-gray-800 text-white hover:bg-white hover:text-gray-800 focus:outline-none focus:text-white focus:bg-gray-800";
                // $inactive = "bg-white text-gray-800 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 "


              $style = "text-gray-900";
              if(
                request()->routeIs('funeral_schedule.index') ||  
                request()->routeIs('funeral_schedule.create') || 
                request()->routeIs('funeral_schedule.edit') || 
                request()->routeIs('funeral_schedule.show') ||
                request()->routeIs('hospice_schedule.index') ||  
                request()->routeIs('hospice_schedule.create') || 
                request()->routeIs('hospice_schedule.edit') ||
                request()->routeIs('hospice_schedule.show') || 

                request()->routeIs('service_schedule.index') ||  
                request()->routeIs('service_schedule.create') || 
                request()->routeIs('service_schedule.edit') ||
                request()->routeIs('service_schedule.show') 
              ){
                $style = "text-blue-500";
              }

            @endphp
            <button id="scheduleDropdownNavbarLink" data-dropdown-toggle="scheduleDropdownNavbar" class="{{ $style }} flex items-center justify-between w-full py-2 px-3    rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto ">
              Schedule 
              <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
              </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="scheduleDropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 ">
                <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdownLargeButton">
                  {{-- <li>
                    <x-flowbite-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                      {{ __('Dashboard') }}
                    </x-flowbite-nav-link>
                  </li> --}}
                  @auth
                    @if(Auth::user()->can('setting list') || Auth::user()->hasRole('Global Administrator'))
                      <li>
                        <x-flowbite-dropdown-link :href="route('funeral_schedule.public.edit')" :active="request()->routeIs('funeral_schedule.public.edit')  " wire:navigate>
                          Edit FullScreen Schedule Display 
                        </x-flowbite-dropdown-link> 
                      </li> 
                    @endif

                  @endauth

                      
                  <li>
                    <x-flowbite-dropdown-link :href="route('funeral_schedule.index')" :active="request()->routeIs('funeral_schedule.index') || request()->routeIs('funeral_schedule.create') || request()->routeIs('funeral_schedule.edit') || request()->routeIs('funeral_schedule.show')" wire:navigate>
                      Funeral Schedule
                    </x-flowbite-dropdown-link> 
                  </li>

                  @auth
                    
                    @if(Auth::user()->can('service schedule list') || Auth::user()->hasRole('Global Administrator'))
                    <li>
                      <x-flowbite-dropdown-link :href="route('service_schedule.index')" :active="request()->routeIs('service_schedule.index') || request()->routeIs('service_schedule.create') || request()->routeIs('service_schedule.edit') || request()->routeIs(patterns: 'service_schedule.show')  " wire:navigate>
                        Service Schedule
                      </x-flowbite-dropdown-link> 
                    </li>
                    @endif

                    @if(Auth::user()->can('hospice schedule list') || Auth::user()->hasRole('Global Administrator'))
                        <li>
                        <x-flowbite-dropdown-link :href="route('hospice_schedule.index')" :active="request()->routeIs('hospice_schedule.index') || request()->routeIs('hospice_schedule.create') || request()->routeIs('hospice_schedule.edit') || request()->routeIs('hospice_schedule.show')  " wire:navigate>
                          Hospice Schedule
                        </x-flowbite-dropdown-link> 
                      </li>
                    @endif
                    

                  @endauth


                </ul>
            </div>
          </li>


          @auth
          <li>

            <!-- Check if system is active-->
            @php
                // $active = "bg-gray-800 text-white hover:bg-white hover:text-gray-800 focus:outline-none focus:text-white focus:bg-gray-800";
                // $inactive = "bg-white text-gray-800 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 "


              $style = "text-gray-900";
              if(
                request()->routeIs('user.index') ||
                request()->routeIs('user.create') ||
                request()->routeIs('user.edit') || 
                request()->routeIs('activity_log.index') || 
                request()->routeIs('role.index') ||
                request()->routeIs('role.create') ||
                request()->routeIs('role.edit') ||
                request()->routeIs('role.permissions') ||
                request()->routeIs('permission.index') ||
                request()->routeIs('permission.create') ||
                request()->routeIs('permission.edit') ||
                request()->routeIs('setting.index') ||
                request()->routeIs('setting.create') ||
                request()->routeIs('setting.edit') 
              ){
                $style = "text-blue-500";
              }

            @endphp
            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar" class="{{ $style }} flex items-center justify-between w-full py-2 px-3    rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 md:w-auto ">
              System 
              <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
              </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="dropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 ">
                <ul class="py-2 text-sm text-gray-700 " aria-labelledby="dropdownLargeButton">
                  {{-- <li>
                    <x-flowbite-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                      {{ __('Dashboard') }}
                    </x-flowbite-nav-link>
                  </li> --}}
                  <li>
                    <x-flowbite-dropdown-link :href="route('user.index')" :active="request()->routeIs('user.index') || request()->routeIs('user.create') || request()->routeIs('user.edit')" wire:navigate>
                      Users
                    </x-flowbite-dropdown-link> 
                  </li>

                  <li> 
                    <x-flowbite-dropdown-link :href="route('role.index')" :active="request()->routeIs('role.index') || request()->routeIs('role.create') || request()->routeIs('role.edit') ||  request()->routeIs('role.permissions') " wire:navigate>
                      Roles
                    </x-flowbite-dropdown-link> 
                  </li>

                  <li> 
                    <x-flowbite-dropdown-link :href="route('permission.index')" :active="request()->routeIs('permission.index') || request()->routeIs('permission.create') || request()->routeIs('permission.edit')" wire:navigate>
                      Permissions
                    </x-flowbite-dropdown-link> 
                  </li>

                  <li>
                    <x-flowbite-dropdown-link :href="route('setting.index')" :active="request()->routeIs('setting.index') || request()->routeIs('setting.create') || request()->routeIs('setting.edit')" wire:navigate>
                      Settings
                    </x-flowbite-dropdown-link> 
                  </li>


                  <li> 
                    <x-flowbite-dropdown-link :href="route('activity_log.index')" :active="request()->routeIs('activity_log.index')" wire:navigate>
                      Activity Logs
                    </x-flowbite-dropdown-link> 
                  </li>

                  
                </ul> 
            </div>
          </li>
          @endauth



          {{-- 
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 ">Services</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 ">Pricing</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 ">Contact</a>
          </li> --}}
  
        </ul>
      </div>
    </div>

    @if(request()->routeIs('dashboard'))
      <div class="hidden   max-w-screen-xl sm:flex flex-wrap items-center justify-around mx-auto p-4 bg-gray-100">
          
        <div class="items-center justify-around hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
          <ul class="flex flex-col items-center font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg   md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0    ">

            
            <li>
                <a href="#funeral_priority_schedules_widget" class="block py-2 px-3   border-b border-transparent hover:text-blue-700 hover:border-blue-700 rounded-sm md:bg-transparent  md:p-0 " aria-current="page">
                  Today
                </a>  
               
            </li>

            <li>
              <a href="#funeral_schedules_widget" class="block py-2 px-3   border-b border-transparent hover:text-blue-700 hover:border-blue-700 rounded-sm md:bg-transparent  md:p-0 " aria-current="page">
                 Schedules
              </a>  
               
            </li>
 
            <li>
              <a href="#funeral_schedules_calendar_widget" class="block py-2 px-3   border-b border-transparent hover:text-blue-700 hover:border-blue-700 rounded-sm md:bg-transparent  md:p-0 " aria-current="page">
                 Calendar
              </a>  
               
            </li>

            <li>
              <a href="#service_schedules_calendar_widget" class="block py-2 px-3   border-b border-transparent hover:text-blue-700 hover:border-blue-700 rounded-sm md:bg-transparent  md:p-0 " aria-current="page">
                 Service
              </a>  
               
            </li>



          </ul>
        </div>
      </div>
    @endif

  </nav>






</nav>
