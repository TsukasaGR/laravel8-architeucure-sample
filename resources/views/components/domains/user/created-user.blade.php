@props(['user' => null, 'createdAt' => null, 'link' => true])

@if ($user)
    <div {{ $attributes->merge(['class' => 'flex item-center']) }}>
        @if ($link)
            <x-utils.forms.a :href="route('user.show', ['user' => $user])" class="font-semibold">
        @endif
        <x-domains.user.thumbnail :thumbnail="$user->thumbnail" />
        @if ($link)
            </x-utils.forms.a>
        @endif
        <div class="ml-2 text-sm">
            @if ($link)
                <x-utils.forms.a :href="route('user.show', ['user' => $user])" class="font-semibold">{{ $user->name }}</x-utils.forms.a>
            @else
                <p class="font-semibold">{{ $user->name }}</p>
            @endif
            <p class="text-xs text-gray-500">{{ $createdAt }}</p>
        </div>
    </div>
@endif
