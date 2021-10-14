@props(['article' => null, 'ownComment' => null])

@if ($article)
    <x-utils.frame {{ $attributes->merge(['class' => '']) }}>
        <form method="POST" action="{{ route('comment.storeOrUpdate', ['article' => $article]) }}">
            @csrf
            <div class="flex">
                <x-domains.user.thumbnail :thumbnail="$article->user->thumbnail" />

                <div class="w-full ml-4">
                    <x-utils.forms.textarea placeholder="コメント" name="comment" class="w-full" required>{{ old('comment', $ownComment) }}</x-utils.forms.textarea>
                </div>
            </div>
            <div class="flex flex-row-reverse mt-4">
                <x-utils.forms.button message="投稿する"/>
            </div>
        </form>
    </x-utils.frame>
@endif
