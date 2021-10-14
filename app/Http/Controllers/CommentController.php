<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreOrUpdateRequest;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * @param StoreOrUpdateRequest $request
     * @param Article $article
     * @return RedirectResponse
     */
    public function storeOrUpdate(StoreOrUpdateRequest $request, Article $article)
    {
        DB::transaction(function () use ($request, $article) {
            Comment::updateOrCreate(
                ['user_id' => Auth::id(), 'article_id' => $article->id],
                ['body' => $request->input('comment')],
            );
        });

        /** @var User $loggedInUser */
        $loggedInUser = Auth::user();
        $ownComment = $article->getUserComment($loggedInUser);
        $flashMessage = $ownComment ? 'コメントを更新しました' : '記事にコメントしました';

        $request->session()->flash('status', $flashMessage);

        return redirect()->route('article.show', compact('article'));
    }
}
