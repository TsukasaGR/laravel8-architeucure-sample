@php
    /** @var \App\Models\Domains\Article\IndexViewModel $indexViewModel */

    $articles = $indexViewModel->articles;
    $q = $indexViewModel->q;
@endphp

<x-layouts.app>
    <x-slot name="header">
        {{ __('記事一覧') }}
    </x-slot>

    <div>
        <x-domains.search.input :url="route('article.index')" :q="$q" />

        <x-domains.article.articles :articles="$articles" class="mt-8" :paginate="true" />
    </div>
</x-layouts.app>
