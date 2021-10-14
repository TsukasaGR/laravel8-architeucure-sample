@props(['comments' => [], 'paginate' => false])

<x-utils.frame {{ $attributes->merge(['class' => '']) }}>
    @forelse($comments as $comment)
        <x-domains.comment.comment :comment="$comment" class="border-t pt-4 pb-4 first:border-t-0 first:pt-0 last:pb-0" />
    @empty
        <p>コメントはありません</p>
    @endforelse
</x-utils.frame>

@if ($paginate)
    <div class="mt-8">
        {{ $comments->appends(request()->input())->links() }}
    </div>
@endif
