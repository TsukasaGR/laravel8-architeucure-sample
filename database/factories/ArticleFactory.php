<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => $this->faker->url(),
            'title' => $this->faker->realText(50),
            'description' => $this->faker->realText(200),
        ];
    }

    /**
     * @param int $userId
     * @return ArticleFactory
     */
    public function user(int $userId)
    {
        return $this->state(function () use ($userId) {
            return [
                'user_id' => $userId,
            ];
        });
    }

    /**
     * @param int $categoryId
     * @return ArticleFactory
     */
    public function category(int $categoryId)
    {
        return $this->state(function () use ($categoryId) {
            return [
                'category_id' => $categoryId,
            ];
        });
    }
}
