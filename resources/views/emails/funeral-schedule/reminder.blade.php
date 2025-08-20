@component('mail::message')
# Funeral Schedule Reminder

Dear {{ $notifiable->name }},

This is a respectful reminder that there is a scheduled funeral for:

**Name of the deceased:** {{ $funeral_schedule->name_of_person }}  
**Date and Time:** {{ \Carbon\Carbon::parse($funeral_schedule->date)->format('F j, Y') }}  
**Location:** {{ $funeral_schedule->burial_cemetery }} at {{ $funeral_schedule->burial_location }}

This notification is shared with relevant team members for awareness and coordination.
 
## Overall Funeral Details:
- **Name of Person:** {{ $funeral_schedule->name_of_person }}
- **Date:** {{ \Carbon\Carbon::parse($funeral_schedule->date)->format('F j, Y') }}
- **Mass Time:** {{ \Carbon\Carbon::parse($funeral_schedule->mass_time)->format('g:i A') }}
- **Public Viewing:** {{ \Carbon\Carbon::parse($funeral_schedule->public_viewing_start)->format('g:i A') }} - {{ \Carbon\Carbon::parse($funeral_schedule->public_viewing_end)->format('g:i A') }}
- **Family Viewing:** {{ \Carbon\Carbon::parse($funeral_schedule->family_viewing_start)->format('g:i A') }} - {{ \Carbon\Carbon::parse($funeral_schedule->family_viewing_end)->format('g:i A') }}
- **Burial Cemetery:** {{ $funeral_schedule->burial_cemetery }}
- **Burial Location:** {{ $funeral_schedule->burial_location }}
- **Hearse:** {{ $funeral_schedule->hearse }}
- **Funeral Director:** {{ $funeral_schedule->funeral_director }}
@if($funeral_schedule->co_funeral_director)
- **Co-Funeral Director:** {{ $funeral_schedule->co_funeral_director }}
@endif

@if($notifiable->hasRole('Global Administrator') || $notifiable->can('funeral schedule view family arrival'))
@if(!empty($familyArrivals) && count($familyArrivals))
## Family Arrival: 
            
@foreach ($familyArrivals as $arrival)
- **{{ $arrival['time'] }}:**  {{ $arrival['notes'] }} 
@endforeach
              
@endif
@endif

@if($notifiable->hasRole('Global Administrator') || $notifiable->can('funeral schedule view flowers'))
@if(!empty($flowers) && count($flowers))
## Flowers: 

@foreach ($flowers as $flower)
- **{{ $flower['name'] }}:**  {{ $flower['notes'] }}
@endforeach
 
@endif
@endif


@if($notifiable->hasRole('Global Administrator') || $notifiable->can('funeral schedule view equipments'))
@if(!empty($equipments) && count($equipments))
## Equipments: 

@foreach ($equipments as $equipment)
- **{{ $equipment['name'] }}:**  {{ $equipment['notes'] }}
@endforeach
 
@endif
@endif

 

@component('mail::button', ['url' => $url])
View Funeral Schedule
@endcomponent

Please review the schedule and prepare accordingly.

Thanks,  
{{ config('app.name') }}
@endcomponent
