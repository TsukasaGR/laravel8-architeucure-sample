<?php

namespace App\Models;

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
}
