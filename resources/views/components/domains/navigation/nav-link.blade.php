@props(['active'])

@php
$baseClasses = 'inline-flex items-center px-1 pt-1 border-b-4 text-sm font-medium leading-5 transition duration-150 ease-in-out ';
$classes = $baseClasses .= ($active ?? false)
            ? 'border-white text-white focus:outline-none focus:border-white'
            : 'border-transparent text-gray-500 hover:text-gray-100 hover:border-gray-300 focus:outline-none focus:text-gray-300 focus:border-gray-300';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
