<x-layouts.app>
    <x-slot name="header">
        {{ __('記事投稿') }}
    </x-slot>

    <x-utils.frame>
        <form method="POST" action="{{ route('article.validateUrl') }}">
            @csrf

            <div class="mt-4">
                <x-utils.forms.label for="url" :value="__('記事URL')" />

                <x-utils.forms.input id="url" class="block mt-1 w-full" type="text" name="url" :value="old('url')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-utils.forms.button class="ml-4" :message="__('次へ')" />
            </div>
        </form>
    </x-utils.frame>
</x-layouts.app>
