<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->realText(200),
        ];
    }

    /**
     * @param int $userId
     * @return CommentFactory
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
     * @param int $articleId
     * @return CommentFactory
     */
    public function article(int $articleId)
    {
        return $this->state(function () use ($articleId) {
            return [
                'article_id' => $articleId,
            ];
        });
    }
}
