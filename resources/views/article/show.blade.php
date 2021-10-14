<x-layouts.app>
    <x-slot name="header">
        {{ __('記事詳細') }}
    </x-slot>

    <div>
        {{ Breadcrumbs::render('article', $article) }}

        <div class="grid gap-8 grid-cols-1 md:grid-cols-2 items-start">
            <!-- 記事詳細 -->
            <x-domains.article.detail-article :article="$article" />

            <div>
                <!-- コメント入力欄 -->
                <x-domains.comment.input :article="$article" :own-comment="$ownComment" />

                <!-- コメント一覧 -->
                <x-domains.comment.comments class="mt-8" :comments="$comments" :paginate="true" />
            </div>
        </div>
    </div>
</x-layouts.app>
