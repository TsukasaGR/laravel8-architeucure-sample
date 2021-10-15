<?php

namespace App\Http\Controllers;

use App\Events\ArticlePosted;
use App\Http\Requests\Article\PreviewRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\ValidateUrlRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Domains\Ogp;
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
        /** @var string|null $q */
        $q = $request->query('q');

        $articles = Article::viewList($q)
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
                    ->defaultOrdered()
                    ->paginate(20);

        /** @var int $loggedInUserId */
        $loggedInUserId = Auth::id();
        $ownComment = $article->getUserComment($loggedInUserId);

        return view('article.show', compact('article', 'comments', 'ownComment'));
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
        $article = DB::transaction(function () use ($request) {
            return Article::create([
                'user_id' => Auth::id(),
                'category_id' => $request->input('categoryId'),
                'url' => $request->input('url'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image_path' => $request->input('imagePath'),
            ]);
        });

        ArticlePosted::dispatch($article);
        $request->session()->flash('status', '記事を投稿しました');

        return redirect()->route('dashboard');
    }
}
