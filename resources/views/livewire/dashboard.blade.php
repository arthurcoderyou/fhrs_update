<div>

  {{-- @if(Auth::check() && (Auth::user()->hasRole('Administrator') ||  Auth::user()->hasRole('Global Administrator')) )
    <livewire:dashboard.admin-dashboard />

  @else   --}}

    <div class="{{ $show_dashboard_today_schedules == "No" ? 'hidden' : 'block' }}"  >
      <livewire:dashboard.priority-schedules-widget /> 
    </div>


    <div class="{{ $show_dashboard_table == "No" ? 'hidden' : 'block' }}"  >
      <livewire:dashboard.funeral-schedules-widget />
    </div>

    <div class="{{ $show_dashboard_calendar == "No" ? 'hidden' : 'block' }}"  >
      <livewire:dashboard.funeral-schedules-calendar-widget />
    </div>

    
    <div class="{{ $show_dashboard_service_calendar == "No" ? 'hidden' : 'block' }}"  >
      <livewire:dashboard.service-schedules-calendar-widget />
    </div>

  {{-- @endif   --}}


</div>