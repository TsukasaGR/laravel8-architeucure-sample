<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Userクラスのリレーション
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Articleクラスのリレーション
     *
     * @return BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * @param Builder $query
     * @return void
     * @comment デフォルトソート順スコープ
     */
    public function scopeDefaultOrdered(Builder $query)
    {
        $query->orderByDesc('comments.updated_at');
    }

    /**
     * @param Builder $query
     * @param int $userId
     * @return void
     * @comment ユーザーIDによるフィルタースコープ
     */
    public function scopeWhereUserId(Builder $query, int $userId)
    {
        $query->where('comments.user_id', $userId);
    }
}
