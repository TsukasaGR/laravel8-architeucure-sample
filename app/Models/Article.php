<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     * @comment Userクラスのリレーション
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     * @comment Categoryクラスのリレーション
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return HasMany
     * @comment Commentクラスのリレーション
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return string
     * @comment 記事画像取得用アクセサ(未設定の場合はノーイメージ画像を返す)
     */
    public function getThumbnailAttribute(): string
    {
        return $this->image_path ?? '/image/noimage.png';
    }

    /**
     * @param Builder $query
     * @return Builder
     * @comment デフォルトのソート順スコープ
     */
    public function scopeDefaultOrdered(Builder $query)
    {
        return $query->orderByDesc('articles.created_at');
    }

    /**
     * @param Builder $query
     * @param string|null $keyword
     * @return Builder
     * @comment キーワードによる検索スコープ
     */
    public function scopeSearchKeyword(Builder $query, ?string $keyword = null)
    {
        if (! $keyword) {
            return $query;
        }

        $escapedKeyword = addcslashes($keyword, '%_\\'); // 検索文字列をそのままの文字列として検索したいが、DBのエスケープ文字の場合そのまま渡すと正しく検索できないため、エスケープ文字の場合はバックスラッシュを付加して検索する
        return $query->where('articles.title', 'like', "%{$escapedKeyword}%")
            ->orWhere('articles.description', 'like', "%{$escapedKeyword}%")
            ->orWhereHas('comments', function ($query) use ($escapedKeyword) {
                $query->where('body', 'like', "%{$escapedKeyword}%");
            });
    }

    /**
     * @param Builder $query
     * @param string|null $keyword
     * @return Builder
     * @comment 画面表示用一覧取得スコープ
     */
    public function scopeViewList(Builder $query, ?string $keyword = null)
    {
        return $query->with(['user', 'comments'])
            ->searchKeyword($keyword)
            ->defaultOrdered();
    }

    /**
     * @param int|null $userId
     * @return string|null
     * @comment 対象記事に対する対象ユーザのコメント取得
     */
    public function getUserComment(?int $userId = null): ?string
    {
        if (! $userId) {
            return null;
        }

        $comment = $this->comments()->whereUserId($userId)->first();
        if (! $comment) {
            return null;
        }
        return $comment->body;
    }
}
