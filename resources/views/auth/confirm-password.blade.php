<x-layouts.app type="guest">
    <div class="mb-4 text-sm text-gray-600">
        {{ __('これは、アプリケーションの安全な領域です。続行する前にパスワードを確認してください。') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
    @csrf

        <!-- Password -->
        <div>
            <x-utils.forms.label for="password" :value="__('パスワード')" />

            <x-utils.forms.input id="password" class="block mt-1 w-full"
                                 type="password"
                                 name="password"
                                 required autocomplete="current-password" />
        </div>

        <div class="flex justify-end mt-4">
            <x-utils.forms.button>
                {{ __('確認') }}
            </x-utils.forms.button>
        </div>
    </form>
</x-layouts.app>
