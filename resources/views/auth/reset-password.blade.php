<x-layouts.app type="guest">
    <!-- Validation Errors -->
    <x-utils.forms.validation-errors class="mb-4" :errors="$errors" />

    <form method="POST" action="{{ route('password.update') }}">
    @csrf

    <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-utils.forms.label for="email" :value="__('メールアドレス')" />

            <x-utils.forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-utils.forms.label for="password" :value="__('パスワード')" />

            <x-utils.forms.input id="password" class="block mt-1 w-full" type="password" name="password" required />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-utils.forms.label for="password_confirmation" :value="__('パスワード（確認）')" />

            <x-utils.forms.input id="password_confirmation" class="block mt-1 w-full"
                                 type="password"
                                 name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-utils.forms.button :message="__('パスワードをリセットする')" />
        </div>
    </form>
</x-layouts.app>
