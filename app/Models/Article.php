<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Userクラスのリレーション
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Categoryクラスのリレーション
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Commentクラスのリレーション
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * 記事画像取得用アクセサ(未設定の場合はノーイメージ画像を返す)
     *
     * @return string
     */
    public function getThumbnailAttribute(): string
    {
        return $this->image_path ?? '/image/noimage.png';
    }

    /**
     * 対象記事に対する対象ユーザのコメント取得
     *
     * @param User|null $user
     * @return string|null
     */
    public function getUserComment(?User $user): ?string
    {
        if (! $user) {
            return null;
        }

        $comment = $this->comments()->where('user_id', $user->id)->first();
        if (! $comment) {
            return null;
        }
        return $comment->body;
    }
}
