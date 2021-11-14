<?php

namespace App\Http\Controllers;

use App\Events\ArticlePosted;
use App\Models\Domains\Article\ArticleRepositoryInterface;
use App\Http\Requests\Article\PreviewRequest;
use App\Http\Requests\Article\StoreRequest;
use App\Http\Requests\Article\ValidateUrlRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Domains\Ogp;
use App\Presenters\Article\IndexPresenter;
use App\Services\Domains\Article\DeleteArticleService;
use App\UseCases\Article\GetViewList\InputData;
use App\UseCases\Article\GetViewList\Interactor;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Throwable;

class ArticleController extends Controller
{
    /**
     * @param Request $request
     * @param ArticleRepositoryInterface $articleGateway
     * @return ViewFactory|View
     */
    public function index(Request $request, ArticleRepositoryInterface $articleGateway)
    {
        /** @var string|null $q */
        $q = $request->query('q');

        // UseCase InputPortの実体を生成する
        $getViewListInputData = new InputData($q);

        // UseCase Interactorを呼び出し、UseCase OutputPortの実体を取得する
        $getViewListOutputData = (new Interactor($articleGateway))($getViewListInputData);

        // PresenterにてViewModelを取得する
        $viewModel = (new IndexPresenter($getViewListOutputData, $q))();

        // ViewModelを渡してViewを表示する
        return view('article.index', $viewModel);
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

    /**
     * UI側は作成していないが、ドメインサービスの実装例用に作成した
     *
     * @param Article $article
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy(Article $article)
    {
        DB::transaction(function () use ($article) {
            (new DeleteArticleService($article))();
        });

        return redirect()->route('dashboard');
    }
}
