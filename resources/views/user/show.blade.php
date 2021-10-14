<x-layouts.app>

    <x-slot name="header">
        {{ $headerMessage }}
    </x-slot>

    <div>
        <x-utils.frame>
            <!-- Name -->
            <div>
                <x-utils.forms.label for="name" :value="__('表示名')" />

                <x-utils.forms.input id="name" class="block mt-1 w-full" type="text" name="name" :value="$user->name" disabled />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-utils.forms.label for="email" :value="__('メールアドレス')" />

                <x-utils.forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="$user->email" disabled />
            </div>

            @if ($canUpdate)
                <div class="flex flex-row-reverse mt-4">
                    <x-utils.forms.a-button message="編集する" href="{{ route('user.edit', ['user' => $user]) }}" />
                </div>
            @endif
        </x-utils.frame>
    </div>
</x-layouts.app>
