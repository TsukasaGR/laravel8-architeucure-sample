<?php

namespace Tests\Feature\Listeners;

use App\Events\ArticlePosted;
use App\Listeners\SendEmailForAdmin;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendEmailForAdminTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function test_handle()
    {
        // メールが送られないよう設定
        Mail::fake();

        // 処理前にメールが送られていないことを確認(当該処理はキューで操作されるためassertSentでなくassertQueuedで行う)
        Mail::assertNothingQueued();

        /** @var User $user */
        $user = User::factory()->create();
        /** @var Category $category */
        $category = Category::factory()->create();
        /** @var Article $article */
        $article = Article::factory()
            ->user($user->id)
            ->category($category->id)
            ->create();

        $event = new ArticlePosted($article);
        (new SendEmailForAdmin())->handle($event);

        // 対象のtoにメールが送信されていることを確認
        Mail::assertQueued(
            \App\Mail\ArticlePosted::class,
            function ($mail) {
                return $mail->to[0]['address'] === config('mail.admin');
            }
        );
    }
}
