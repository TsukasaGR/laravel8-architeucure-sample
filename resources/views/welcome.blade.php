<x-layouts.app type="guest">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 text-center">
        <div>
            <x-utils.forms.a-button message="新規登録" type="main" href="{{ route('register') }}">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </x-slot>
            </x-utils.forms.a-button>
        </div>
        <div class="mt-8">
            <x-utils.forms.a-button message="ログイン" type="sub" href="{{ route('login') }}">
                <x-slot name="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                    </svg>
                </x-slot>
            </x-utils.forms.a-button>
        </div>
    </div>
</x-layouts.app>
