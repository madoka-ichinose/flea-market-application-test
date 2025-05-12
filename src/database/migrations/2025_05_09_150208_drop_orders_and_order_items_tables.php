<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }

    public function down(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->user_id();
            $table->timestamps();
            
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->order_id();
            $table->product_id();
            $table->quantity();
            $table->price();
            $table->unsignedBigInteger('order_id');
            $table->timestamps();
        });
    }
};

