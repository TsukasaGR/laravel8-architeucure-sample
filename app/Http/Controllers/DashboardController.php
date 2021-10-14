<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * @return ViewFactory|View
     */
    public function __invoke()
    {
        $articles = Article::with(['user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact('articles'));
    }
}
