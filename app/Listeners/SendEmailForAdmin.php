<?php

namespace App\Listeners;

use App\Events\ArticlePosted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ArticlePosted as ArticlePostedEmail;

class SendEmailForAdmin implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ArticlePosted $event
     * @return void
     */
    public function handle(ArticlePosted $event)
    {
        $article = $event->article;
        Mail::to(config('mail.admin'))->send(new ArticlePostedEmail($article));
    }
}
