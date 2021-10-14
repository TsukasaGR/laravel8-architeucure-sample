<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\PreviewRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\ValidateUrlRequest;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use App\Utils\Ogp;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class ArticleController extends Controller
{
    /**
     * @param Request $request
     * @return ViewFactory|View
     */
    public function index(Request $request)
    {
        /** @var string $q */
        $q = $request->query('q');

        $searchQuery = addcslashes($q, '%_\\'); // 検索文字列をそのままの文字列として検索したいが、DBのエスケープ文字の場合そのまま渡すと正しく検索できないため、エスケープ文字の場合はバックスラッシュを付加して検索する
        $articles = Article::with(['user', 'comments'])
            ->where('title', 'like', "%{$searchQuery}%")
            ->orWhere('description', 'like', "%{$searchQuery}%")
            ->orWhereHas('comments', function ($query) use ($searchQuery) {
                $query->where('body', 'like', "%{$searchQuery}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('article.index', compact('articles', 'q'));
    }

    /**
     * @param Article $article
     * @return ViewFactory|View
     */
    public function show(Article $article)
    {
        $comments = $article->comments()
                    ->orderBy('comments.updated_at', 'desc')
                    ->paginate(20);

        /** @var User $loggedInUser */
        $loggedInUser = Auth::user();
        $ownComment = $article->getUserComment($loggedInUser);

        return view('article.show', compact('article', 'comments', 'loggedInUser', 'ownComment'));
    }

    /**
     * @return ViewFactory|View
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * @param ValidateUrlRequest $request
     * @return RedirectResponse
     */
    public function validateUrl(ValidateUrlRequest $request)
    {
        /** @var string $url */
        $url = $request->input('url');
        $encodedUrl = urlencode($url);

        return redirect()->route('article.preview', ['url' => $encodedUrl]);
    }

    /**
     * @param PreviewRequest $request
     * @return ViewFactory|View
     */
    public function preview(PreviewRequest $request)
    {
        /** @var string $url */
        $url = $request->query('url');
        $decodedUrl = urldecode($url);
        $ogp = (new Ogp($decodedUrl))();
        $categories = Category::all();

        return view('article.preview', [
            'url' => $decodedUrl,
            'title' => $ogp->title,
            'description' => $ogp->description,
            'imagePath' => $ogp->imagePath,
            'categories' => $categories,
        ]);
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        DB::transaction(function () use ($request) {
            Article::create([
                'user_id' => Auth::id(),
                'category_id' => $request->input('categoryId'),
                'url' => $request->input('url'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image_path' => $request->input('imagePath'),
            ]);
        });

        $request->session()->flash('status', '記事を投稿しました');

        return redirect()->route('dashboard');
    }
}
