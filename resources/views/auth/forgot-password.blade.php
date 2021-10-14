<x-layouts.app type="guest">
    <div class="mb-4 text-sm text-gray-600">
        {{ __('パスワードをお忘れですか？問題ありません。あなたのメールアドレスをお知らせいただければ、新しいパスワードを選択するためのパスワードリセットリンクをメールでお送りします。') }}
    </div>

    <form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email Address -->
        <div>
            <x-utils.forms.label for="email" :value="__('メールアドレス')" />

            <x-utils.forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-utils.forms.button :message="__('パスワードをリセットする')" />
        </div>
    </form>
</x-layouts.app>
