<?php /** @noinspection NonAsciiCharacters */

namespace Tests\Feature\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    // TODO: setUpでmigrationを実行するときはDatabaseMigrationsを実行すること
//    use DatabaseMigrations;
    use RefreshDatabase;

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

    public function test_index_ログインしていない状態で一覧にアクセスするとログイン画面にリダイレクトされる()
    {
        $response = $this->get(route('article.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_index_ログインしている状態で記事一覧ページにアクセスできる()
    {
        $this->getUserWithLogin();
        $response = $this->get(route('article.index'));
        $response->assertStatus(200)
            ->assertSee('記事一覧');
    }

    public function test_show_記事詳細ページにアクセスできる()
    {
        $user = $this->getUserWithLogin();
        $this->actingAs($user);
        $category = Category::factory()->create();
        $article = Article::factory()
            ->user($user->id)
            ->category($category->id)
            ->create();
        $response = $this->get(route('article.show', ['article' => $article]));
        $response->assertStatus(200)
            ->assertSee('記事詳細');
    }

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
        return [
            'URLが空白' => ['', false, ['url']],
            'URLが不正' => ['aaaaaaa', false, ['url']],
            'URLが正常' => ['https://ok.example.com', false, []],
            'URLが既に登録済み' => ['https://ng.example.com', true, ['url']],
        ];
    }

    /**
     * @param $url
     * @param $isCreateArticle
     * @param $errors
     * @dataProvider validateUrlDataProvider
     */
    public function test_validateUrl_不正なURLではバリデーションエラーになる($url, $isCreateArticle, $errors)
    {
        $user = $this->getUserWithLogin();
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

    public function test_validateUrl_正常なURLでは記事作成プレビューページにリダイレクトされる()
    {
        $this->getUserWithLogin();
        $url = 'https://example.com';
        $encodedUrl = urlencode($url);
        $response = $this->post(route('article.validateUrl'), ['url' => $url]);
        $response->assertRedirect(route('article.preview', ['url' => $encodedUrl]));
    }

    /**
     * @param $url
     * @param $isCreateArticle
     * @param $errors
     * @dataProvider validateUrlDataProvider
     */
    public function test_preview_不正なURLではバリデーションエラーになる($url, $isCreateArticle, $errors)
    {
        $user = $this->getUserWithLogin();
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

    public function test_preview_正常なURLでは記事作成プレビューページにアクセスできる()
    {
        $this->getUserWithLogin();
        $url = 'https://example.com';
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
     * @param $url
     * @param $categoryId
     * @param $title
     * @param $description
     * @param $errors
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

    public function test_store_正常に登録完了し、記事投稿イベントが発火する()
    {
        $this->getUserWithLogin();
        $category = Category::factory()->create();

        $response = $this->post(route('article.store'), [
            'url' => 'https://example123.com',
            'categoryId' => $category->id,
            'title' => 'title',
            'description' => 'description',
        ]);

        $response->assertRedirect(route('dashboard'));
    }
}
