@props(['message' => 'ボタン', 'type' => 'main', 'icon' => null])

@php
        $classes = 'inline-flex items-center justify-center text-center text-xs tracking-widest';
        $mainClasses = ' px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150';
        $subClasses = ' underline text-sm text-gray-600 hover:text-gray-900';

        if (isset($type)) {
            if ($type === 'sub') {
                $classes .= $subClasses;
            } elseif($type === 'main') {
                $classes .= $mainClasses;
            }
        }

        if (isset($icon) && $icon) {
            $classes .= ' flex';
        }

@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <span>{{ $icon }}</span>
    @endif
    <span>{{ $message }}</span>
</button>
