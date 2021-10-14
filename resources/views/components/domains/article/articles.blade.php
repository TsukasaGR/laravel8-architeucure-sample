@props(['articles' => [], 'paginate' => false])

<div {{ $attributes->merge(['class' => 'grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3']) }}>

    @forelse($articles as $article)
        <x-domains.article.list-article :article="$article"/>
    @empty
        <p>記事はありません</p>
    @endforelse
</div>

@if ($paginate)
    <div class="mt-8">
        {{ $articles->appends(request()->input())->links() }}
    </div>
@endif
