@props(['href' => ''])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'hover:opacity-70']) }}>
    {{ $slot }}
</a>
