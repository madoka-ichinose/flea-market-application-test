<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
        'product_name' => '腕時計',
        'price' => 15000 ,
        'description' => 'スタイリッシュなデザインのメンズ腕時計',
        'image' =>'images/Clock.jpg',
        'condition' => '良好',
        'user_id' => 1,
        'category_id' => 1,
    ];
     DB::table('products')->insert($param);

        $param = [
        'product_name' => 'HDD',
        'price' => 5000 ,
        'description' => '高速で信頼性の高いハードディスク',
        'image' =>'images/HDD+Hard+Disk.jpg',
        'condition' => '目立った傷や汚れなし',
        'user_id' => 2,
        'category_id' => 2,
    ];
     DB::table('products')->insert($param);

        $param = [
        'product_name' => '玉ねぎ３束',
        'price' => 300 ,
        'description' => '新鮮な玉ねぎ３束のセット',
        'image' =>'images/onion.jpg',
        'condition' => 'やや傷や汚れあり',
        'user_id' => 1,
        'category_id' => 10,
    ];
     DB::table('products')->insert($param);

     $param = [
        'product_name' => '革靴',
        'price' => 4000 ,
        'description' => 'クラシックなデザインの革靴',
        'image' =>'images/Shoes.jpg',
        'condition' => '状態が悪い',
        'user_id' => 2,
        'category_id' => 5,
    ];
     DB::table('products')->insert($param);

      $param = [
        'product_name' => 'ノートPC',
        'price' => 45000 ,
        'description' => '高性能なノートパソコン',
        'image' =>'images/Laptop.jpg',
        'condition' => '良好',
        'user_id' => 3,
        'category_id' => 2,
    ];
     DB::table('products')->insert($param);

     $param = [
        'product_name' => 'マイク',
        'price' => 8000 ,
        'description' => '高音質のレコーディング用マイク',
        'image' =>'images/Mic.jpg',
        'condition' => '目立った傷や汚れなし',
        'user_id' => 3,
        'category_id' => 2,
    ];
     DB::table('products')->insert($param);

     $param = [
        'product_name' => 'ショルダーバック',
        'price' => 3500 ,
        'description' => 'おしゃれなショルダーバッグ',
        'image' =>'images/Purse.jpg',
        'condition' => 'やや傷や汚れあり',
        'user_id' => 1,
        'category_id' => 4,
    ];
     DB::table('products')->insert($param);

      $param = [
        'product_name' => 'タンブラー',
        'price' => 500 ,
        'description' => '使いやすいタンブラー',
        'image' =>'images/Tumbler.jpg',
        'condition' => '状態が悪い',
        'user_id' => 1,
        'category_id' => 10,
    ];
     DB::table('products')->insert($param);

     $param = [
        'product_name' => 'コーヒーミル',
        'price' => 4000 ,
        'description' => '手動のコーヒーミル',
        'image' =>'images/Grinder.jpg',
        'condition' => '良好',
        'user_id' => 1,
        'category_id' => 10,
    ];
     DB::table('products')->insert($param);

      $param = [
        'product_name' => 'メイクセット',
        'price' =>  2500,
        'description' => '便利なメイクアップセット',
        'image' =>'images/makeup.jpg',
        'condition' => '目立った傷や汚れなし',
        'user_id' => 1,
        'category_id' => 4,
    ];
     DB::table('products')->insert($param);
    }
}
