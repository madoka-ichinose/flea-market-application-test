<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;

class SetSellerIdInProductsSeeder extends Seeder
{
    public function run(): void
    {
        $firstUser = User::first(); 

        if ($firstUser) {
            Product::whereNull('seller_id')->update([
                'seller_id' => $firstUser->id,
            ]);
        }
    }
}
