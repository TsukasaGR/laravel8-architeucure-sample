<x-layouts.app type="guest">
    <div class="mb-4 text-sm text-gray-600">
        {{ __('ご登録ありがとうございます。ご登録の前に、Eメールでお送りしたリンクをクリックして、メールアドレスを確認していただけますか？万が一、メールが届いていない場合は、再度メールをお送りいたします。') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('登録時に入力されたEメールアドレスに新しい認証リンクが送信されました。') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-utils.forms.button :message="__('検証メールを再送する')" />
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-utils.forms.button :message="__('ログアウト')" class="ml-4" />
        </form>
    </div>
</x-layouts.app>
