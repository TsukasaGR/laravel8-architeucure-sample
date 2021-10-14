<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * testXXX(001~)@example.comのユーザーを作成する
     *
     * @param int $number 作成するユーザーの数
     * @return static
     */
    public function templateUser(int $number)
    {
        return $this->state(function (array $attributes) use ($number) {
            $formattedNumber = sprintf('%03d', $number);
            return [
                'name' => "テスト{$formattedNumber}",
                'email' => "test{$formattedNumber}@example.com",
            ];
        });
    }
}
