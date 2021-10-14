@props(['comment' => null])

@if ($comment)
    <div {{ $attributes }}>
        <x-domains.user.created-user :user="$comment->user" :createdAt="$comment->display_created_at" />

        <div class="mt-2">
            <p class="whitespace-pre-wrap">{{ $comment->body }}</p>
        </div>
    </div>
@endif
