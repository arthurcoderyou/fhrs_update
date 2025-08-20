<!-- resources/views/components/tooltip.blade.php -->

<dd class="mt-1.5 text-base font-semibold text-gray-500 max-w-[9rem] text-wrap overflow-hidden"
    data-tooltip-target="{{ $id }}"
>
    {{ $trigger }}
</dd>

<div id="{{ $id }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip">
    {{ $message }}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>