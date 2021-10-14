<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as BreadcrumbTrail;

Breadcrumbs::for('articles', function (BreadcrumbTrail $trail) {
    $trail->push('記事一覧', route('article.index'));
});

Breadcrumbs::for('article', function (BreadcrumbTrail $trail, \App\Models\Article $article) {
    $trail->parent('articles');
    $trail->push('記事詳細', route('article.show', ['article' => $article]));
});

Breadcrumbs::for('article.create', function (BreadcrumbTrail $trail) {
    $trail->push('記事投稿', route('article.create'));
});

Breadcrumbs::for('article.preview', function (BreadcrumbTrail $trail, string $url) {
    $trail->parent('article.create');
    $trail->push('記事投稿 - 確認', route('article.preview', ['url' => urlencode($url)]));
});
