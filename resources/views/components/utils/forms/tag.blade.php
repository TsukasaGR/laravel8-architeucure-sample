@props(['value'])

<label {{ $attributes->merge(['class' => 'font-medium text-sm bg-gray-200 text-gray-700 p-2 rounded-lg']) }}>
    {{ $value ?? $slot }}
</label>
