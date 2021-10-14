@props(['thumbnail' => null])

@if ($thumbnail)
    <img {{ $attributes->merge(['class' => 'w-10 h-10 object-cover rounded-full shadow']) }} src="{{ $thumbnail }}" alt="thumbnail">
@endif
