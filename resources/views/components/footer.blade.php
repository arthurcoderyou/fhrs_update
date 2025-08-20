<footer class="p-4 bg-white md:p-8 lg:p-10  ">
    <div class="mx-auto max-w-screen-xl text-center">
        <a href="#" class="flex justify-center items-center text-2xl font-semibold text-gray-900  ">
                <x-application-logo />
                    
        </a>
        <p class="my-6 text-gray-500 ">Funeral Homes Reservation System</p>
        <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900  ">

            @auth
                <li>
                    <a href="{{ route(name: 'dashboard') }}" wire:navigate class="mr-4 hover:underline md:mr-6 ">Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('funeral_schedule.index') }}" wire:navigate class="mr-4 hover:underline md:mr-6">Funeral Schedule</a>
                </li>
                <li>
                    <a href="{{ route('hospice_schedule.index') }}" wire:navigate class="mr-4 hover:underline md:mr-6 ">Hospice Schedule</a>
                </li>
                <li>
                    <a href="{{ route('profile') }}" wire:navigate class="mr-4 hover:underline md:mr-6">Profile</a>
                </li> 
            @endauth

            @guest  
                 <li>
                    <a href="{{ route('login') }}" wire:navigate class="mr-4 hover:underline md:mr-6">Login</a>
                </li>
                <li>
                    <a href="{{ route('register') }}" wire:navigate class="mr-4 hover:underline md:mr-6 ">Sign Up</a>
                </li>
            @endguest


        </ul>
        <span class="text-sm text-gray-500 sm:text-center ">© {{ date('Y') }} <a href="https://dimensionsystems.com/" class="hover:underline">Dimension Systems, Inc</a>. All Rights Reserved.</span>
    </div>
</footer>