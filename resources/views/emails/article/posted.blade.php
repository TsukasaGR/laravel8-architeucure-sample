@component('mail::message')
# 新しい記事が投稿されました！

## タイトル

{{ $article->title }}

## 投稿者

{{ $article->user->name }}

@component('mail::button', ['url' => route('article.show', ['article' => $article])])
記事を読む
@endcomponent

@endcomponent
