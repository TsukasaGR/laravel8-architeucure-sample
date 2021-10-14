<x-layouts.app>
    <x-slot name="header">
        {{ __('記事投稿 - 確認') }}
    </x-slot>

    {{ Breadcrumbs::render('article.preview', $url) }}

    <x-utils.frame>
        <form method="POST" action="{{ route('article.store') }}">
            @csrf

            <div>
                <x-utils.forms.label :value="__('記事URL')" />

                <x-utils.forms.input type="text" :value="old('url', $url)" class="w-full" disabled />
                <input type="hidden" name="url" value="{{ old('url', $url) }}" />
            </div>

            <div class="mt-4">
                <x-utils.forms.label for="categoryId" :value="__('カテゴリー')" />

                <x-utils.forms.select name="categoryId" class="w-full" autofocus placeholder="カテゴリーを選択">
                    <option value=""></option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </x-utils.forms.select>
            </div>

            <div class="mt-4">
                <x-utils.forms.label for="title" :value="__('タイトル')" />

                <x-utils.forms.input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $title)" required />
            </div>

            <div class="mt-4">
                <x-utils.forms.label for="description" :value="__('ディスクリプション')" />

                <x-utils.forms.textarea id="description" class="w-full h-48" name="description" required>{{ old('description', $description) }}</x-utils.forms.textarea>
            </div>

            <div class="mt-4">
                <x-utils.forms.label for="imagePath" :value="__('サムネイル')" />

                @if (old('imagePath', $imagePath))
                    <img src="{{ old('imagePath', $imagePath )}}" class="w-96 object-contain" />
                    <input type="hidden" name="imagePath" value="{{ old('imagePath', $imagePath )}}" />
                @endif
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-utils.forms.button class="ml-4" :message="__('投稿')" />
            </div>
        </form>
    </x-utils.frame>
</x-layouts.app>
