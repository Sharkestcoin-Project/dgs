<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('price', 2)->nullable();
            $table->boolean('buyer_can_set_price')->default(0);
            $table->boolean('notify_previous_buyer')->default(0);
            $table->string('file')->nullable();
            $table->integer('size')->nullable();
            $table->string('cover')->nullable();
            $table->string('return_url')->nullable();
            $table->string('theme_color')->nullable();
            $table->json('meta')->nullable();
            $table->foreignId('currency_id')->constrained();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
