@props(['size' => 'full', 'padding' => true])

@php
    $classes = 'w-full bg-white shadow-md overflow-hidden sm:rounded-lg';

    if (isset($size) && $size === 'md') {
        $classes .= ' sm:max-w-md ';
    }

    if (isset($padding) && $padding) {
        $classes .= ' px-6 py-4 ';
    } else {
        $classes .= ' p-0 ';
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
