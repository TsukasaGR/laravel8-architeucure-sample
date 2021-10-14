@props(['url' => null, 'q' => null])

<div {{ $attributes }}>
    <form method="GET" action="{{ route('article.index') }}">
        @if ($q)
            <p class="text-lg pb-4">「{{ $q }}」の検索結果</p>
        @endif
        <div class="w-full h-10 pl-3 pr-2 bg-white shadow-md sm:rounded-lg  flex justify-between items-center relative">
            <input type="search" name="q" id="q" placeholder="検索..." value="{{ $q }}"
                   class="appearance-none w-full outline-none border-none p-0 focus:outline-none active:outline-none focus:ring-transparent" />
            <button class="ml-1 outline-none focus:outline-none active:outline-none">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                     viewBox="0 0 24 24" class="w-6 h-6">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>
