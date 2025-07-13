@props(['color' => 'default'])

@php
    $baseClasses = 'inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';
    $styles = match($color) {
        'canary' => 'bg-[#a8ff04] border-[#a8ff04] text-black hover:bg-lime-400 focus:ring-lime-500 focus:ring-offset-gray-100',
        default => 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-500 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:ring-indigo-500 dark:focus:ring-offset-gray-800',
    };
@endphp

<button {{ $attributes->merge(['type' => 'button', 'class' => "$baseClasses $styles"]) }}>
    {{ $slot }}
</button>
