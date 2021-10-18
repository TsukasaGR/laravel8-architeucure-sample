<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Feature\Controllers;

use App\Events\ArticlePosted;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @return User
     */
    private function getUserWithLogin()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    /**
     * @return void
     */
    public function test_index_ログインしていない状態で一覧にアクセスするとログイン画面にリダイレクトされる()
    {
        $response = $this->get(route('article.index'));
        $response->assertRedirect(route('login'));
    }

    /**
     * @return void
     */
    public function test_index_ログインしている状態で記事一覧ページにアクセスできる()
    {
        $this->getUserWithLogin();
        $response = $this->get(route('article.index'));
        $response->assertStatus(200)
            ->assertSee('記事一覧');
    }

    /**
     * @return void
     */
    public function test_show_記事詳細ページにアクセスできる()
    {
        $user = $this->getUserWithLogin();
        $this->actingAs($user);
        /** @var Category $category */
        $category = Category::factory()->create();
        $article = Article::factory()
            ->user($user->id)
            ->category($category->id)
            ->create();
        $response = $this->get(route('article.show', ['article' => $article]));
        $response->assertStatus(200)
            ->assertSee('記事詳細');
    }

    /**
     * @return void
     */
    public function test_create_記事投稿ページにアクセスできる()
    {
        $this->getUserWithLogin();
        $response = $this->get(route('article.create'));
        $response->assertStatus(200)
            ->assertSee('記事投稿');
    }

    /**
     * @return array[]
     */
    public function validateUrlDataProvider()
    {
        // TODO: fakerを使って値を設定したいが、dataProvider内でfakerを使う方法がわからないため直書きにしている
        return [
            'URLが空白' => ['', false, ['url']],
            'URLが不正' => ['aaaaaaa', false, ['url']],
            'URLが正常' => ['https://ok.example.com', false, []],
            'URLが既に登録済み' => ['https://ng.example.com', true, ['url']],
        ];
    }

    /**
     * @param string $url
     * @param bool $isCreateArticle
     * @param array $errors
     * @return void
     * @dataProvider validateUrlDataProvider
     */
    public function test_validateUrl_不正なURLではバリデーションエラーになる($url, $isCreateArticle, $errors)
    {
        $user = $this->getUserWithLogin();
        /** @var Category $category */
        $category = Category::factory()->create();
        if ($isCreateArticle) {
            Article::factory()
                ->user($user->id)
                ->category($category->id)
                ->url($url)
                ->create();
        }
        $response = $this->post(route('article.validateUrl'), ['url' => $url]);
        $response->assertSessionHasErrors($errors);
    }

    /**
     * @return void
     */
    public function test_validateUrl_正常なURLでは記事作成プレビューページにリダイレクトされる()
    {
        $this->getUserWithLogin();
        $url = $this->faker->url();
        $encodedUrl = urlencode($url);
        $response = $this->post(route('article.validateUrl'), ['url' => $url]);
        $response->assertRedirect(route('article.preview', ['url' => $encodedUrl]));
    }

    /**
     * @param string $url
     * @param bool $isCreateArticle
     * @param array $errors
     * @return void
     * @dataProvider validateUrlDataProvider
     */
    public function test_preview_不正なURLではバリデーションエラーになる($url, $isCreateArticle, $errors)
    {
        $user = $this->getUserWithLogin();
        /** @var Category $category */
        $category = Category::factory()->create();
        if ($isCreateArticle) {
            Article::factory()
                ->user($user->id)
                ->category($category->id)
                ->url($url)
                ->create();
        }
        $response = $this->get(route('article.preview', ['url' => urlencode($url)]));
        $response->assertSessionHasErrors($errors);
    }

    /**
     * @return void
     */
    public function test_preview_正常なURLでは記事作成プレビューページにアクセスできる()
    {
        $this->getUserWithLogin();
        $url = $this->activeRandomUrl();
        $response = $this->get(route('article.preview', ['url' => urlencode($url)]));
        $response->assertStatus(200)
            ->assertSee('記事投稿 - 確認');
    }

    /**
     * @return array[]
     */
    public function storeDataProvider()
    {
        return [
            '必須未入力' => ['', null, '', '', ['url', 'categoryId', 'title', 'description']],
            '存在しないカテゴリー' => ['https://example.com', -1, 'title', 'description', ['categoryId']],
        ];
    }

    /**
     * @param string $url
     * @param int|null $categoryId
     * @param string $title
     * @param string $description
     * @param array $errors
     * @return void
     * @dataProvider storeDataProvider
     */
    public function test_store_バリデーションエラーになる($url, $categoryId, $title, $description, $errors)
    {
        $this->getUserWithLogin();
        $response = $this->post(route('article.store'), [
            'url' => $url,
            'categoryId' => $categoryId,
            'title' => $title,
            'description' => $description,
        ]);
        $response->assertSessionHasErrors($errors);
    }

    /**
     * @return void
     */
    public function test_store_正常に登録完了し、記事投稿イベントが発火する()
    {
        // テストでイベントが発火しないようにするためfakeを呼び出す
        Event::fake();

        $this->getUserWithLogin();
        /** @var Category $category */
        $category = Category::factory()->create();

        $url = $this->activeRandomUrl();
        $categoryId = $category->id;
        $title = $this->faker->title();
        $description = $this->faker->realText(100);
        $response = $this->post(
            route('article.store'),
            compact('url', 'categoryId', 'title', 'description')
        );

        // レスポンスのテスト
        $response->assertRedirect(route('dashboard'))
            ->assertSessionHas('status');

        // データが正常に登録されたかのテスト(ドメインサービスで登録処理を行っている場合はコントローラーではテストせず、サービス側のテストに任せる)
        $isArticleExists = Article::where('url', $url)
            ->where('category_id', $categoryId)
            ->where('title', $title)
            ->where('description', $description)
            ->exists();
        $this->assertTrue($isArticleExists);

        // イベントが発火したかのテスト(ここでは発火したかどうかのテストのみで、リスナーのテストは別途行う)
        Event::assertDispatched(ArticlePosted::class);
    }
}
