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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
            $table->string('username')->unique();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('role')->default('user');
            $table->string('password')->nullable();
            $table->foreignId('plan_id')->nullable();
            $table->json('plan_meta')->nullable();
            $table->date('will_expire')->nullable();
            $table->string('token')->nullable();
            $table->integer('status')->default(1); //1= active 2= paused 0 = suspend
            $table->json('meta')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
