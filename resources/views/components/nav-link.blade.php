@props(['active'])

@php
$classes = ($active ?? false)
? 'inline-flex items-center px-3 pt-1 border-b-2 border-mustard-500 text-sm font-semibold text-maroon-800 dark:text-maroon-100 focus:outline-none focus:border-mustard-600 transition duration-150 ease-in-out'
: 'inline-flex items-center px-3 pt-1 border-b-2 border-transparent text-sm font-medium text-maroon-500 hover:text-maroon-700 hover:border-mustard-400 focus:outline-none focus:text-maroon-700 focus:border-mustard-500 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>