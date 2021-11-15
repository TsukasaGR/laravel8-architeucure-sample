<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Feature\Domains\Article\Services;

use App\Domains\Article\Services\ArticleService;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array user, articleの順に格納されている
     */
    private function createUserAndArticle()
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Category $category */
        $category = Category::factory()->create();
        $article = Article::factory()
            ->user($user->id)
            ->category($category->id)
            ->create();

        return [$user, $article];
    }

    /**
     * @return void
     */
    public function test_articleCommentsPaginate_表示順序が登録降順である()
    {
        /** @var User $user */
        /** @var Article $article */
        [$user, $article] = $this->createUserAndArticle();
        /** @var Comment $comment */
        $comment = Comment::factory()
            ->user($user->id)
            ->article($article->id)
            ->create();

        // 2つのコメントの登録日時に差を付けるため1秒スリープする
        sleep(1);

        /** @var User $otherUser */
        $otherUser = User::factory()->create();
        /** @var Comment $otherComment */
        $otherComment = Comment::factory()
            ->user($otherUser->id)
            ->article($article->id)
            ->create();

        $articleService = new ArticleService($article);
        $articleComments = $articleService->articleCommentsPaginate();

        // 2件目に登録したデータが最初に取得されることを確認
        /** @var Comment $firstComment */
        $firstComment = $articleComments->items()[0];
        /** @var Comment $secondComment */
        $secondComment = $articleComments->items()[1];
        $this->assertSame($otherComment->id, $firstComment->id);
        $this->assertSame($comment->id, $secondComment->id);
    }

    /**
     * @return void
     */
    public function test_articleCommentsPaginate_ページネーションが効いている()
    {
        /** @var Article $article */
        $article = $this->createUserAndArticle()[1];

        $perPage = 5;

        // perPage+1兼のデータを作成する
        for ($i = 0; $i <= $perPage; $i++) {
            /** @var User $otherUser */
            $otherUser = User::factory()->create();
            Comment::factory()
                ->user($otherUser->id)
                ->article($article->id)
                ->create();
        }

        $articleService = new ArticleService($article);
        $articleComments = $articleService->articleCommentsPaginate($perPage);

        // perPageに設定した件数のみ取得できることを確認
        $this->assertSame($perPage, $articleComments->count());
    }

    /**
     * @return array[]
     */
    public function userCommentDataProvider()
    {
        return [
            'ユーザーのコメントが存在しない場合Nullが返る' => [false, 'assertNull'],
            'ユーザーのコメントが存在する場合、コメントが返る' => [true, 'assertNotNull'],
        ];
    }

    /**
     * @param bool $isCreateComment
     * @param string $assertMethod
     * @return void
     * @dataProvider userCommentDataProvider
     */
    public function test_userComment(bool $isCreateComment, string $assertMethod)
    {
        /** @var User $user */
        /** @var Article $article */
        [$user, $article] = $this->createUserAndArticle();

        if ($isCreateComment) {
            Comment::factory()
                ->user($user->id)
                ->article($article->id)
                ->create();
        }

        $articleService = new ArticleService($article);
        $userComment = $articleService->userComment($user->id);
        $this->$assertMethod($userComment);
    }

    /**
     * @return void
     */
    public function test_create_記事が登録される()
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var Category $category */
        $category = Category::factory()->create();
        /** @var Article $article */
        $article = Article::factory()
            ->user($user->id)
            ->category($category->id)
            ->make();
        $articleService = new ArticleService($article);
        $articleService->create();

        // 対象のモデルがDBに登録されていることを確認する
        $this->assertModelExists($article);
    }
}
