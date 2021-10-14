<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テストログインしやすいように固定で10名ユーザーを作成しておく
        for ($i = 1; $i <= 10; $i++) {
            User::factory()
                ->templateUser($i)
                ->create();
        }

        // ランダムでユーザーを100名作成
        User::factory()
            ->count(100)
            ->create();
    }
}
