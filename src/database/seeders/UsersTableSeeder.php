<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'ユーザー1',
                'email' => 'user1@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'id' => 2,
                'name' => 'ユーザー2',
                'email' => 'user2@example.com',
                'password' => bcrypt('password'),
            ],
            [
                'id' => 3,
                'name' => 'ユーザー3',
                'email' => 'user3@example.com',
                'password' => bcrypt('password'),
            ],
        ]);
    
        // 任意でランダムユーザーも追加する場合
        User::factory()->count(12)->create(); // 残り12人
    }
}
