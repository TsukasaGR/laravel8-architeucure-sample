@props(['article' => null])

@if ($article)
    <x-utils.frame {{ $attributes->merge(['class' => 'flex flex-col']) }} :padding="false">

        <x-utils.forms.a target="_blank" href="{{ $article->url }}">
            <img src="{{ $article->thumbnail }}" alt="thumbnail" class="block w-full h-48 sm:rounded-lg sm:rounded-b-none object-cover">
        </x-utils.forms.a>
        <div class="px-4 py-2 my-2">
            <h2 class="font-bold text-2xl text-gray-800 tracking-normal line-clamp-2">
                <x-utils.forms.a target="_blank" href="{{ $article->url }}">
                    {{ $article->title }}
                </x-utils.forms.a>
            </h2>
            <x-utils.forms.tag class="py-2 my-2 inline-block">
                {{ $article->category->name }}
            </x-utils.forms.tag>

            <x-domains.user.created-user :user="$article->user" :createdAt="$article->display_created_at" class="my-3" />

            <x-utils.forms.a-button target="_blank" href="{{ $article->url }}" message="続きを読む" class="w-full"/>
        </div>
    </x-utils.frame>
@endif
