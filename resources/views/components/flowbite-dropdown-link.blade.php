@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block px-4 py-2 hover:bg-gray-100 bg-blue-500 text-white'
            : 'block px-4 py-2 hover:bg-gray-100 ';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
