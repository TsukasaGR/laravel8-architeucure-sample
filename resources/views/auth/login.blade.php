<x-layouts.app type="guest">
    <!-- Session Status -->
    <x-utils.forms.session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-utils.forms.validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
        <div>
            <x-utils.forms.label for="email" :value="__('メールアドレス')" />

            <x-utils.forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-utils.forms.label for="password" :value="__('パスワード')" />

            <x-utils.forms.input id="password" class="block mt-1 w-full"
                     type="password"
                     name="password"
                     required autocomplete="current-password" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <x-utils.forms.label for="remember_me" class="inline-flex items-center">
                <x-utils.forms.checkbox id="remember_me" name="remember" />
                <span class="ml-2 text-sm text-gray-600">{{ __('ログインしたままにする') }}</span>
            </x-utils.forms.label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-utils.forms.a-button :href="route('password.request')" :message="__('パスワードを忘れた方')" type="sub"/>

            <x-utils.forms.button :message="__('ログイン')" class="ml-4" />
        </div>
    </form>
</x-layouts.app>
