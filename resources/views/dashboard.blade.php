<x-layouts.app>
    <x-slot name="header">
        {{ __('ダッシュボード') }}
    </x-slot>

    <div>
        <p class="text-lg pb-4">最近投稿された記事</p>
        <x-domains.article.articles :articles="$articles" />
    </div>
</x-layouts.app>
